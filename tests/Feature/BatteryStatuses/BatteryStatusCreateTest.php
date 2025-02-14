<?php

namespace BatteryStatuses;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BatteryStatusCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'status' => 24.55,
        ];

        $response = $this->json('post', 'api/battery-status/new', $request);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'last_insert_id' => json_decode($response->getContent(), true)['last_insert_id'],
        ]);
    }

    public function test_create_missing_required_field(): void
    {
        $request = [ 'sensor_id' => 1 ];

        $response = $this->json('post', 'api/battery-status/new', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "STATUS" je zahtevano.',
            'errors' => [
                'status' => [
                    'Polje "STATUS" je zahtevano.',
                ]
            ]
        ]);
    }

    public function test_create_invalid_format(): void
    {
        $request = [
            'sensor_id' => 1,
            'status' => 124.55,
        ];

        $response = $this->json('post', 'api/battery-status/new', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "STATUS" mora biti med 0.00 in 100.00.',
            'errors' => [
                'status' => [
                    'Polje "STATUS" mora biti med 0.00 in 100.00.',
                ]
            ]
        ]);
    }

    public function test_create_missing_sensor(): void
    {
        $request = [
            'sensor_id' => 12356,
            'status' => 24.55,
        ];

        $response = $this->json('post', 'api/battery-status/new', $request);

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
