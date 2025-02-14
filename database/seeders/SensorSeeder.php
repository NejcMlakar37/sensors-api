<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sensors')->insert([
            ['name' => 'Sensor 1', 'location' => 'Hala 1', 'position' => 0 ],
            ['name' => 'Sensor 2', 'location' => 'Hala 2', 'position' => 1 ],
            ['name' => 'Sensor 3', 'location' => 'Hala 3', 'position' => 2 ],
            ['name' => 'Sensor 4', 'location' => 'Hala 4', 'position' => 3 ],
        ]);
    }
}
