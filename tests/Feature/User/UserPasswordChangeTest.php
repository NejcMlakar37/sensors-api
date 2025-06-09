<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class UserPasswordChangeTest extends TestCase
{
    public function test_password_change_all_ok(): void
    {
        $request = [
            'email' => 'user1@gmail.com',
            'old_password' => 'password',
            'new_password' => 'password123'
        ];

        $response = $this->json('post', 'api/change-password', $request);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $loginRequest = [
            'email' => 'user1@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->json('post', 'api/login', $loginRequest);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

    }

    public function test_invalid_user(): void
    {
        $request = [
            'email' => '4234e2dasda@gmail.com',
            'old_password' => 'password',
            'new_password' => 'password123'
        ];

        $response = $this->json('post', 'api/change-password', $request);

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => 'Nepravilno geslo ali e-mail!'
        ]);
    }


    public function test_invalid_password(): void
    {
        $request = [
            'email' => 'user1@gmail.com',
            'old_password' => '12331password',
            'new_password' => 'password123'
        ];

        $response = $this->json('post', 'api/change-password', $request);

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => 'Nepravilno geslo ali e-mail!'
        ]);
    }
}
