<?php

namespace Tests\Feature\Recipients;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipientCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'email' => 'n.mlakar@resistec.si',
        ];

        $response = $this->json('post', 'api/recipient/new', $request);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    public function test_create_missing_required_field(): void
    {
        $request = ['sensor_id' => 1];

        $response = $this->json('post', 'api/recipient/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "EMAIL" je zahtevano.',
            'errors' => [
                'email' => [
                    'Polje "EMAIL" je zahtevano.',
                ]
            ]
        ]);
    }

    public function test_create_invalid_format(): void
    {
        $request = [
            'sensor_id' => 1,
            'email' => 'dsadasdi',
        ];

        $response = $this->json('post', 'api/recipient/new', $request);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "EMAIL" mora biti veljaven e-mail račun.',
            'errors' => [
                'email' => [
                    'Polje "EMAIL" mora biti veljaven e-mail račun.'
                ]
            ]
        ]);
    }

    public function test_create_missing_sensor(): void
    {
        $request = [
            'sensor_id' => -211,
            'email' => 'n.mlakar@resistec.si',
        ];

        $response = $this->json('post', 'api/recipient/new', $request);
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
