<?php

namespace Tests\Feature\Recipients;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipientUpdateTest extends TestCase
{
    use RefreshDatabase;

    private int $recipientId;

    protected function setUp(): void
    {
        parent::setUp();

        $request = [
            'sensor_id' => 1,
            'email' => 'n.mlakar@resistec.si',
        ];

        $this->recipientId = json_decode($this->json('post', 'api/recipient/new', $request)->getContent(), true)['last_insert_id'];
    }


    public function test_update_all_ok(): void
    {
        $request = [
            'recipient_id' => $this->recipientId,
            'sensor_id' => 2,
            'email' => 'n.mlakar123@resistec.si',
        ];

        $response = $this->json('put', 'api/recipient/update', $request);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'data' => [
                'id' => $this->recipientId,
                'sensor' => [
                    'id' => 2,
                    'name' => 'Sensor 2',
                    'location' => 'Hala 2',
                ],
                'email' => 'n.mlakar123@resistec.si',
            ],
        ]);
    }

    public function test_update_nonexistent(): void
    {
        $request = [
            'recipient_id' => $this->recipientId,
            'sensor_id' => -121,
            'email' => 'n.mlakar123@resistec.si',
        ];

        $response = $this->json('put', 'api/recipient/update', $request);
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
            'recipient_id' => $this->recipientId,
            'sensor_id' => 1,
        ];

        $response = $this->json('put', 'api/recipient/update', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "EMAIL" je zahtevano.',
            'errors' => [
                'email' => [
                    'Polje "EMAIL" je zahtevano.'
                ]
            ]
        ]);
    }
}
