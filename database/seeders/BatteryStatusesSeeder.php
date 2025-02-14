<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BatteryStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();
        $sensor = DB::table('sensors')->first();

        for ($i=0; $i < 480; $i++) {
            DB::table('battery_statuses')->insert([
                'sensor_id' => $sensor->id,
                'status' => fake()->randomFloat(2, 0, 100),
                'created_at' => $date->toDateTimeString(),
            ]);

            $date->addMinutes(30);
        }
    }
}
