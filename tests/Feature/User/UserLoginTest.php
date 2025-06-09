<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_all_ok(): void
    {
        $request = [
            'email' => 'user1@gmail.com',
            'password' => 'password',
        ];

        $response = $this->json('post', 'api/login', $request);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_login_wrong_password(): void
    {
        $request = [
            'email' => 'user1@gmail.com',
            'password' => '312321',
        ];

        $response = $this->json('post', 'api/login', $request);

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => 'Nepravilno geslo ali e-mail!'
        ]);
    }

    public function test_login_wrong_user(): void
    {
        $request = [
            'email' => '4234e2dasda@gmail.com',
            'password' => 'password',
        ];

        $response = $this->json('post', 'api/login', $request);

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => 'Nepravilno geslo ali e-mail!'
        ]);
    }
}




