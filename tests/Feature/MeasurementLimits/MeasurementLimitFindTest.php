<?php

namespace Tests\Feature\MeasurementLimits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeasurementLimitFindTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'min_humidity' => 40.00,
            'max_humidity' => 50.00,
        ];

        $limitId = json_decode($this->json('post', 'api/measurement-limit/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('get', 'api/measurement-limit/' . $limitId);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $limitId,
                'sensor' => [
                    'id' => 1,
                    'name' => 'Sensor 1 - 1',
                    'location' => 'Hala 1',
                ],
                'min_temp' => '20.00',
                'max_temp' => '30.00',
                'min_humidity' => '40.00',
                'max_humidity' => '50.00',
            ],
        ]);
    }

    public function test_find_empty(): void
    {
        $response = $this->json('get', 'api/measurement-limit/find/12532');
        $response->assertStatus(404);
    }
}
