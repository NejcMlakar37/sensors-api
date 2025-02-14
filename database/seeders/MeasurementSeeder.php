<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();
        $sensor = DB::table('sensors')->first();

        for ($i=0; $i < 480; $i++) {
            DB::table('measurements')->insert([
                'sensor_id' => $sensor->id,
                'temperature' => fake()->randomFloat(2, 18, 35),
                'humidity' => fake()->randomFloat(2, 30, 70),
                'timestamp' => $date->toDateTimeString()
            ]);

            $date->addMinutes(15);
        }
    }
}
