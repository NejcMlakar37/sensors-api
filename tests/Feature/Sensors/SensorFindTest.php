<?php

namespace Sensors;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorFindTest extends TestCase
{
    use RefreshDatabase;

    private int $companyId = -1;
    private int $sensorId = -1;

    protected function setUp(): void
    {
        parent::setUp();
        $companyRequest = [
            'name' => 'test-company-1',
            'address' => 'Hala 1',
            'city' => 'Mengeš',
            'postcode' => '1234',
            'country' => 'Slovenija',
            'email' => 't.testko@gmail.com',
        ];

        $this->companyId = json_decode($this->json('post', 'api/company/new', $companyRequest)->getContent(), true)['last_insert_id'];

        $sensorRequest = [
            'name' => 'test-sensor-1',
            'location' => 'Hala 1',
            'position' => 89,
            'company' => $this->companyId,
        ];

        $this->sensorId = json_decode($this->json('post', 'api/sensor/new', $sensorRequest)->getContent(), true)['last_insert_id'];
    }

    public function test_find_all_ok(): void
    {
        $response = $this->json('get', 'api/sensor/find/' . $this->sensorId);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $this->sensorId,
                'name' => 'test-sensor-1',
                'location' => 'Hala 1',
                'position' => 89,
                'company' => $this->companyId,
            ],
        ]);
    }

    public function test_find_nonexistent(): void
    {
        $response = $this->json('get', 'api/sensor/find/-123');
        $response->assertStatus(404);
    }

    public function test_find_incorrect_type(): void
    {
        $response = $this->json('get', 'api/sensor/find/dsadsada');
        $response->assertStatus(500);
    }
}
