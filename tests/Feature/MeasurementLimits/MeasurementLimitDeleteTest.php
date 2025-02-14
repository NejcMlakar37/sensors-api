<?php

namespace Tests\Feature\MeasurementLimits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeasurementLimitDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'min_temp' => 20.00,
            'max_temp' => 30.00,
            'min_humidity' => 40.00,
            'max_humidity' => 50.00,
        ];

        $limitId = json_decode($this->json('post', 'api/measurement-limit/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('delete', 'api/measurement-limit/' . $limitId);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_delete_nonexistent(): void
    {
        $response = $this->json('delete', 'api/measurement-limit/-11');
        $response->assertStatus(404);
    }
}
