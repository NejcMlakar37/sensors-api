<?php

namespace Tests\Feature\Recipients;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipientFindTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'email' => 'n.mlakar@resistec.si',
        ];

        $recipientId = json_decode($this->json('post', 'api/recipient/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('get', 'api/recipient/' . $recipientId);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $recipientId,
                'sensor' => [
                    'id' => 1,
                    'name' => 'Sensor 1 - 1',
                    'location' => 'Hala 1',
                ],
                'email' => 'n.mlakar@resistec.si',
            ],
        ]);
    }

    public function test_find_empty(): void
    {
        $response = $this->json('get', 'api/recipient/find/12532');
        $response->assertStatus(404);
    }
}
