<?php

namespace App\Console\Commands;

use App\Models\Measurement;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMeasurements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-measurements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new measurements for all sensors';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating measurements for all sensors...');
        $sensors = Sensor::all();
        $measurementsCreated = 0;
        foreach ($sensors as $sensor) {
            try {
                // Get the last measurement for realistic progression
                $lastMeasurement = Measurement::where('sensor_id', $sensor->id)
                    ->latest('timestamp')
                    ->first();

                // Generate temperature (18-26°C range)
                $temperature = $this->generateValue(
                    $lastMeasurement?->temperature ?? rand(1800, 2600) / 100,
                    18, 26
                );

                // Generate humidity (35-75% range)
                $humidity = $this->generateValue(
                    $lastMeasurement?->humidity ?? rand(3500, 7500) / 100,
                    35, 75
                );

                // Create the measurement
                $measurement = new Measurement([
                    'sensor_id' => $sensor->id,
                    'temperature' => round($temperature, 2),
                    'humidity' => round($humidity, 2),
                    'timestamp' => Carbon::now(),
                ]);

                if ($measurement->save()) {
                    $measurementsCreated++;
                    $this->line("Created measurement for {$sensor->name}: {$temperature}°C, {$humidity}% RH");
                }

            } catch (\Exception $e) {
                $this->error("Error for sensor {$sensor->id}: " . $e->getMessage());
            }
        }

        $this->info("Generated {$measurementsCreated} measurements for {$sensors->count()} sensors.");
        return Command::SUCCESS;
    }

    /**
     * Generate a new value based on the previous value with small variance
     */
    private function generateValue(float $previousValue, float $min, float $max): float
    {
        // Small random change (-1.5 to +1.5)
        $change = (mt_rand() / mt_getrandmax() - 0.5) * 3;
        $newValue = $previousValue + $change;

        // Keep within bounds
        return max($min - 3, min($max + 3, $newValue));
    }
}
