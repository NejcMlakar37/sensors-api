<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = DB::table('companies')->get();
        for($i = 0; $i < count($companies); $i++) {
            User::factory()->create([
                'email' => 'user' . $companies[$i]->id . '@gmail.com',
                'password' => Hash::make('password'),
                'company_id' => $companies[$i]->id,
            ]);
        }
    }
}
