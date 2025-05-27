<?php

namespace Commands;

use App\Models\Measurement;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GenerateMeasurementsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2024-01-15 12:00:00');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_can_generate_measurements_for_all_sensors()
    {
        // Act
        $exitCode = Artisan::call('app:generate-measurements');

        // Assert
        $this->assertEquals(0, $exitCode);
        $this->assertDatabaseHas('measurements', ['sensor_id' => 1]);
        $this->assertDatabaseHas('measurements', ['sensor_id' => 2]);
        $this->assertDatabaseHas('measurements', ['sensor_id' => 3]);
        $this->assertDatabaseHas('measurements', ['sensor_id' => 4]);
        $this->assertEquals(Sensor::query()->count(), Measurement::query()->count());
    }

    public function test_generates_temperature_within_expected_range()
    {
        // Act
        Artisan::call('app:generate-measurements');

        // Assert
        $measurement = Measurement::query()->first();
        $this->assertGreaterThanOrEqual(15, $measurement->temperature); // min - 3
        $this->assertLessThanOrEqual(29, $measurement->temperature);    // max + 3
    }

    public function test_generates_humidity_within_expected_range()
    {
        // Act
        Artisan::call('app:generate-measurements');

        // Assert
        $measurement = Measurement::query()->first();
        $this->assertGreaterThanOrEqual(32, $measurement->humidity); // min - 3
        $this->assertLessThanOrEqual(78, $measurement->humidity);    // max + 3
    }

    public function test_creates_measurements_with_current_timestamp()
    {
        // Act
        Artisan::call('app:generate-measurements');

        // Assert
        $measurement = Measurement::query()->first();
        $this->assertEquals('2024-01-15 12:00:00', Carbon::parse($measurement->timestamp)->format('Y-m-d H:i:s'));
    }

    public function test_rounds_values_to_two_decimal_places()
    {
        // Act
        Artisan::call('app:generate-measurements');

        // Assert
        $measurement = Measurement::query()->first();
        $this->assertEquals(2, strlen(substr(strrchr($measurement->temperature, "."), 1)));
        $this->assertEquals(2, strlen(substr(strrchr($measurement->humidity, "."), 1)));
    }
}
