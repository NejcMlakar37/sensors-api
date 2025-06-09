<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyUpdateTest extends TestCase
{
    use RefreshDatabase;

    private int $companyId = -1;

    protected function setUp(): void
    {
        parent::setUp();
        $request = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko@gmail.com',
        ];

        $this->companyId = json_decode($this->json('post', 'api/company/new', $request)->getContent(), true)['last_insert_id'];
    }

    public function test_update_all_ok(): void
    {
        $request = [
            'name' => 'test-company-2',
            'address' => 'Hala 2',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko123@gmail.com',
        ];

        $response = $this->json('put', 'api/company/update/' . $this->companyId, $request);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $this->companyId,
                'name' => 'test-company-2',
                'address' => 'Hala 2',
                'city' => 'Mengeš',
                'postcode' => '1234',
                'country' => 'Slovenija',
                'email' => 't.testko123@gmail.com',
            ],
        ]);
    }

    public function test_update_nonexistent(): void
    {
        $request = [
            'name' => 'test-company-2',
            'address' => 'Hala 2',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko123@gmail.com',
        ];

        $response = $this->json('put', 'api/company/update/-17', $request);
        $response->assertStatus(404);
    }

    public function test_update_missing_required(): void
    {
        $request = [
            'address' => 'Hala 2',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko123@gmail.com',
        ];

        $response = $this->json('put', 'api/company/update/1', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "IME" je zahtevano.',
            'errors' => [
                'name' => [
                    'Polje "IME" je zahtevano.'
                ]
            ]
        ]);
    }
}
