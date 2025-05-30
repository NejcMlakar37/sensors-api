<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SensorSeeder::class,
//            MeasurementSeeder::class,
            BatteryStatusesSeeder::class,
        ]);
    }
}
