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
        $companies = DB::table('companies')->get();

        for($i = 0; $i < count($companies); $i++) {
            DB::table('sensors')->insert([
                ['name' => 'Sensor 1' . " - " . $companies[$i]->id, 'location' => 'Hala 1', 'position' => 0, 'company_id' => $companies[$i]->id ],
                ['name' => 'Sensor 2' . " - " . $companies[$i]->id, 'location' => 'Hala 2', 'position' => 1, 'company_id' => $companies[$i]->id ],
                ['name' => 'Sensor 3' . " - " . $companies[$i]->id, 'location' => 'Hala 3', 'position' => 2, 'company_id' => $companies[$i]->id ],
            ]);
        }
    }
}
