<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyFindTest extends TestCase
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

    public function test_find_all_ok(): void
    {
        $response = $this->json('get', 'api/company/find/' . $this->companyId);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $this->companyId,
                'name' => 'test-company-1',
                'address' => 'Hala 1',
                'city' => 'Mengeš',
                'postcode' => '1234',
                'country' => 'Slovenija',
                'email' => 't.testko@gmail.com',
            ],
        ]);
    }

    public function test_find_nonexistent(): void
    {
        $response = $this->json('get', 'api/company/find/-123');
        $response->assertStatus(404);
    }

    public function test_find_incorrect_type(): void
    {
        $response = $this->json('get', 'api/company/find/dsadsada');
        $response->assertStatus(500);
    }
}
