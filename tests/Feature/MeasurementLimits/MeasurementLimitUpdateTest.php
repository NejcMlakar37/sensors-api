<?php

namespace Tests\Feature\MeasurementLimits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeasurementLimitUpdateTest extends TestCase
{
    use RefreshDatabase;

    private int $limitId;

    protected function setUp(): void
    {
        parent::setUp();

        $request = [
            'sensor_id' => 1,
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'min_humidity' => 40.00,
            'max_humidity' => 50.00,
        ];

        $this->limitId = json_decode($this->json('post', 'api/measurement-limit/new', $request)->getContent(), true)['last_insert_id'];
    }


    public function test_update_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'min_temp' => 25.00,
            'max_temp' => 35.00,
            'min_humidity' => 45.00,
            'max_humidity' => 55.00,
        ];

        $response = $this->json('put', 'api/measurement-limit/update', $request);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'data' => [
                'id' => $this->limitId,
                'sensor' => [
                    'id' => 1,
                    'name' => 'Sensor 1',
                    'location' => 'Hala 1',
                ],
                'min_temp' => 25.00,
                'max_temp' => 35.00,
                'min_humidity' => 45.00,
                'max_humidity' => 55.00,
            ],
        ]);
    }

    public function test_update_nonexistent(): void
    {
        $request = [
            'sensor_id' => -17,
            'min_temp' => 25.00,
            'max_temp' => 35.00,
            'min_humidity' => 45.00,
            'max_humidity' => 55.00,
        ];

        $response = $this->json('put', 'api/measurement-limit/update', $request);
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

    public function test_update_missing_required(): void
    {
        $request = [
            'sensor_id' => 1,
            'min_temp' => 25.00,
            'max_temp' => 35.00,
            'max_humidity' => 55.00,
        ];

        $response = $this->json('put', 'api/measurement-limit/update', $request);

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
}
