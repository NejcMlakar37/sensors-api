<?php

namespace Tests\Feature\Recipients;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipientDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_all_ok(): void
    {
        $request = [
            'sensor_id' => 1,
            'email' => 'n.mlakar@resistec.si',
        ];

        $recipientId = json_decode($this->json('post', 'api/recipient/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('delete', 'api/recipient/' . $recipientId);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_delete_nonexistent(): void
    {
        $response = $this->json('delete', 'api/recipient/-11');
        $response->assertStatus(404);
    }
}
