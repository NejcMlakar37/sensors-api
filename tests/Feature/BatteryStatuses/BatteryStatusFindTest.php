<?php

namespace BatteryStatuses;

use App\Models\BatteryStatus;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BatteryStatusFindTest extends TestCase
{
    use RefreshDatabase;

    private Collection $statuses;

    protected function setUp(): void
    {
        parent::setUp();
        $sensor = Sensor::query()->findOrFail(1);
        $this->statuses = BatteryStatus::factory()->for($sensor, 'sensor')->count(20)->create();
    }

    public function test_find_all_ok(): void
    {
        $status = $this->statuses->first();

        $response = $this->json('get', 'api/battery-status/' . $status->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $status->id,
                'sensor_id' => 1,
                'status' => $status->status,
                'created_at' => Carbon::parse($status->created_at)->format('Y-m-d'),
            ],
        ]);
    }

    public function test_find_empty(): void
    {
        $response = $this->json('get', 'api/battery-status/find/12532');
        $response->assertStatus(404);
    }
}
