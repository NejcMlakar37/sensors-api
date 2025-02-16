<?php

namespace Sensors;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorUpdateTest extends TestCase
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
            'name' => 'test-sensor-1',
            'location' => 'Hala-test-1',
            'position' => 12,
            'company' => $this->companyId,
        ];

        $response = $this->json('put', 'api/sensor/update/1', $request);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => 1,
                'name' => 'test-sensor-1',
                'location' => 'Hala-test-1',
                'position' => 12,
                'company' => $this->companyId,
            ],
        ]);
    }

    public function test_update_nonexistent(): void
    {
        $request = [
            'name' => 'test-sensor-1',
            'location' => 'Hala-test-1',
            'position' => 12,
            'company' => $this->companyId,
        ];

        $response = $this->json('put', 'api/sensor/update/-17', $request);
        $response->assertStatus(404);
    }

    public function test_update_missing_required(): void
    {
        $request = [
            'name' => 'test-sensor-1',
            'position' => 12,
            'company' => $this->companyId,
        ];

        $response = $this->json('put', 'api/sensor/update/1', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Polje "LOKACIJA" je zahtevano.',
            'errors' => [
                'location' => [
                    'Polje "LOKACIJA" je zahtevano.'
                ]
            ]
        ]);
    }
}
