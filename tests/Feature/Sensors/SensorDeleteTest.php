<?php

namespace Sensors;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_all_ok(): void
    {
        $request = [
            'name' => 'test-sensor-123',
            'location' => 'Hala 123',
            'position' => 123,
        ];

        $sensorId = json_decode($this->json('post', 'api/sensor/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('delete', 'api/sensor/' . $sensorId);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_delete_connected(): void
    {
        $response = $this->json('delete', 'api/sensor/1');

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => "Sensor ima povezane entitete"
        ]);
    }

    public function test_delete_nonexistent(): void
    {
        $response = $this->json('delete', 'api/sensor/-11');
        $response->assertStatus(404);
    }
}
