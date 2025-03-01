<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Basic User', 'slug' => 'basic', 'description' => 'Regular user with limited access'],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Administrator with elevated privileges'],
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Super administrator with full access'],
        ]);
    }
}
