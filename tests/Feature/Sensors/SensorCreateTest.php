<?php

namespace Sensors;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_all_ok(): void
    {
        $request = [
            'name' => 'test-sensor-1',
            'location' => 'Hala 1',
            'position' => 89,
        ];

        $response = $this->json('post', 'api/sensor/new', $request);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    public function test_create_missing_required_field(): void
    {
        $request = [
            'name' => 'test-sensor-1',
            'position' => 89,
        ];

        $response = $this->json('post', 'api/sensor/new', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "LOKACIJA" je zahtevano.',
            'errors' => [
                'location' => [
                    'Polje "LOKACIJA" je zahtevano.'
                ]
            ]
        ]);
    }

    public function test_create_invalid_format(): void
    {
        $request = [
            'name' => 12321,
            'location' => 'Hala 1',
            'position' => 89,
        ];

        $response = $this->json('post', 'api/sensor/new', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "IME" mora biti besedilo.',
            'errors' => [
                'name' => [
                    'Polje "IME" mora biti besedilo.'
                ]
            ]
        ]);
    }

    public function test_create_duplicate(): void
    {
        $request = [
            'name' => 'test-sensor-1',
            'location' => 'Hala 1',
            'position' => 4539,
        ];

        $this->json('post', 'api/sensor/new', $request);
        $response = $this->json('post', 'api/sensor/new', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje IME s to vrednostjo že obstaja. (and 1 more error)',
            'errors' => [
                'name' => [
                    'Polje IME s to vrednostjo že obstaja.',
                ],
                'position' => [
                    'Polje POZICIJA s to vrednostjo že obstaja.',
                ]
            ]
        ]);
    }
}
