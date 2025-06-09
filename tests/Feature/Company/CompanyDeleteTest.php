<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyDeleteTest extends TestCase
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

    public function test_delete_all_ok(): void
    {
        $response = $this->json('delete', 'api/company/' . $this->companyId);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_delete_connected(): void
    {
        $sensorRequest = [
            'name' => 'test-sensor-1',
            'location' => 'Hala 1',
            'position' => 89,
            'company' => $this->companyId,
        ];

        $this->json('post', 'api/sensor/new', $sensorRequest);
        $response = $this->json('delete', 'api/company/' .  $this->companyId);

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => "Podjetje ima povezane senzorje!"
        ]);
    }

    public function test_delete_nonexistent(): void
    {
        $response = $this->json('delete', 'api/company/-11');
        $response->assertStatus(404);
    }
}
