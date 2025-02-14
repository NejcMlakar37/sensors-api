<?php

namespace Tests\Feature\MeasurementLimits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeasurementLimitCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'min_humidity' => 40.00,
            'max_humidity' => 50.00,
        ];

        $response = $this->json('post', 'api/measurement-limit/new', $request);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    public function test_create_missing_required_field(): void
    {
        $request = [
            'sensor_id' => 1,
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'max_humidity' => 50.00,
        ];

        $response = $this->json('post', 'api/measurement-limit/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "MINIMALNA VLAGA" je zahtevano.',
            'errors' => [
                'min_humidity' => [
                    'Polje "MINIMALNA VLAGA" je zahtevano.',
                ]
            ]
        ]);
    }

    public function test_create_invalid_format(): void
    {
        $request = [
            'sensor_id' => 'dsadsa',
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'min_humidity' => 40.00,
            'max_humidity' => 50.00,
        ];

        $response = $this->json('post', 'api/measurement-limit/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "SENZOR" mora biti številka.',
            'errors' => [
                'sensor_id' => [
                    'Polje "SENZOR" mora biti številka.',
                ]
            ]
        ]);
    }

    public function test_create_missing_sensor(): void
    {
        $request = [
            'sensor_id' => -17,
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'min_humidity' => 40.00,
            'max_humidity' => 50.00,
        ];

        $response = $this->json('post', 'api/measurement-limit/new', $request);
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
