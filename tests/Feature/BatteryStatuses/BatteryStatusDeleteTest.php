<?php

namespace BatteryStatuses;

use App\Models\BatteryStatus;
use App\Models\Sensor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BatteryStatusDeleteTest extends TestCase
{
    use RefreshDatabase;

    private BatteryStatus $status;

    protected function setUp(): void
    {
        parent::setUp();
        $sensor = Sensor::query()->findOrFail(1);
        $this->status = BatteryStatus::factory()->for($sensor, 'sensor')->create();
    }

    public function test_delete_all_ok(): void
    {
        $response = $this->json('delete', 'api/battery-status/' . $this->status->id);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_delete_nonexistent(): void
    {
        $response = $this->json('delete', 'api/sensor/-11');
        $response->assertStatus(404);
    }
}
