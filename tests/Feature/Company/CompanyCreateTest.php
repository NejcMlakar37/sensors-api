<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_all_ok(): void
    {
        $request = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko@gmail.com',
        ];

        $response = $this->json('post', 'api/company/new', $request);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    public function test_create_missing_required_field(): void
    {
        $request = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
        ];

        $response = $this->json('post', 'api/company/new', $request);

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

    public function test_create_invalid_format(): void
    {
        $request = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234123',
            'country' => 'Slovenija',
            'email' => 't.testko@gmail.com',
        ];

        $response = $this->json('post', 'api/company/new', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje POŠTNA ŠTEVILKA ne sme imeti več kot 4 števk.',
            'errors' => [
                'postcode' => [
                    'Polje POŠTNA ŠTEVILKA ne sme imeti več kot 4 števk.'
                ]
            ]
        ]);
    }

    public function test_create_duplicate(): void
    {
        $request = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko@gmail.com',
        ];

        $request2 = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko123@gmail.com',
        ];

        $this->json('post', 'api/company/new', $request);
        $response = $this->json('post', 'api/company/new', $request2);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje IME s to vrednostjo že obstaja.',
            'errors' => [
                'name' => [
                    'Polje IME s to vrednostjo že obstaja.',
                ],
            ]
        ]);
    }
}
