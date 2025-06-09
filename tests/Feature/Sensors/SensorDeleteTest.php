<?php

namespace Sensors;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorDeleteTest extends TestCase
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
        $request = [
            'name' => 'test-sensor-123',
            'location' => 'Hala 123',
            'position' => 123,
            'company' => $this->companyId,
        ];

        $sensorId = json_decode($this->json('post', 'api/sensor/new', $request)->getContent(), true)['last_insert_id'];
        $response = $this->json('delete', 'api/sensor/' . $sensorId);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_delete_connected(): void
    {
        $request = [
            'name' => 'test-sensor-123',
            'location' => 'Hala 123',
            'position' => 123,
            'company' => $this->companyId,
        ];

        $sensorId = json_decode($this->json('post', 'api/sensor/new', $request)->getContent(), true)['last_insert_id'];

        $requestMeasurement = [
            'sensor_id' => $sensorId,
            'temperature' => 24.55,
            'humidity' => 44.90,
        ];

        $this->json('post', 'api/measurement/new', $requestMeasurement);
        $response = $this->json('delete', 'api/sensor/' . $sensorId);

        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => "Sensor ima povezane entitete"
        ]);
    }

    public function test_delete_nonexistent(): void
    {
        $response = $this->json('delete', 'api/sensor/-11');
        $response->assertStatus(404);
    }
}
