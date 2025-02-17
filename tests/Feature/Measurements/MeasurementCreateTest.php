<?php

namespace Tests\Feature\Measurements;

use App\Models\Sensor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeasurementCreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            Sensor::query()->first(),
            ['*'],
            'api-sensors'
        );
    }

    public function test_create_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'temperature' => 24.55,
            'humidity' => 44.90,
        ];

        $response = $this->json('post', 'api/measurement/new', $request);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_create_missing_required_field(): void
    {
        $request = [
            'temperature' => 24.55,
            'humidity' => 44.90,
        ];

        $response = $this->json('post', 'api/measurement/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "SENZOR" je zahtevano.',
            'errors' => [
                'sensor_id' => [
                    'Polje "SENZOR" je zahtevano.',
                ]
            ]
        ]);
    }

    public function test_create_invalid_format(): void
    {
        $request = [
            'sensor_id' => "dsadsada",
            'temperature' => 24.55,
            'humidity' => 44.90,
        ];

        $response = $this->json('post', 'api/measurement/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Izbran/a "SENZOR" ni veljaven/a. (and 1 more error)',
            'errors' => [
                'sensor_id' => [
                    'Izbran/a "SENZOR" ni veljaven/a.',
                    'Polje "SENZOR" mora biti številka.'
                ]
            ]
        ]);
    }

    public function test_create_missing_sensor(): void
    {
        $request = [
            'sensor_id' => -17,
            'temperature' => 24.55,
            'humidity' => 44.90,
        ];

        $response = $this->json('post', 'api/measurement/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Izbran/a "SENZOR" ni veljaven/a.',
            'errors' => [
                'sensor_id' => [
                    'Izbran/a "SENZOR" ni veljaven/a.'
                ]
            ]
        ]);
    }
}
