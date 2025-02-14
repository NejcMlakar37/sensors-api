<?php

namespace Measurements;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeasurementFindTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'temperature' => 24.55,
            'humidity' => 44.90,
        ];

        $measurementId = json_decode($this->json('post', 'api/measurement/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('get', 'api/measurement/find/'.$measurementId);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $measurementId,
                'sensor' => [
                    'id' => 1,
                    'name' => 'Sensor 1',
                    'location' => 'Hala 1',
                ],
                'temperature' => 24.55,
                'humidity' => 44.90,
            ],
        ]);
    }

    public function test_find_empty(): void
    {
        $response = $this->json('get', 'api/measurement/find/1122312');
        $response->assertStatus(404);
    }
}
