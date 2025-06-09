<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSensorToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sensor-token {sensor_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an API token for sensor.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle(): void
    {
        $sensor = Sensor::query()->findOrFail($this->argument('sensor_id'));
        $token = Str::random(32);

        $sensor->tokens()->delete();

        $newToken = $sensor->createToken('device-token', ['measurements:create'], null, $token);

        $this->info("Sensor token generated successfully:");
        $this->info($newToken->plainTextToken);
    }
}
