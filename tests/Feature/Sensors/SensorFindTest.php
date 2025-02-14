<?php

namespace Sensors;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorFindTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_all_ok(): void
    {
        $response = $this->json('get', 'api/sensor/find/1');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => 1,
                'name' => 'Sensor 1',
                'location' => 'Hala 1',
                'position' => 0,
            ],
        ]);
    }

    public function test_find_nonexistent(): void
    {
        $response = $this->json('get', 'api/sensor/find/-123');
        $response->assertStatus(404);
    }

    public function test_find_incorrect_type(): void
    {
        $response = $this->json('get', 'api/sensor/find/dsadsada');
        $response->assertStatus(500);
    }
}
