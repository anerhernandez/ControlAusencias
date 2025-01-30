<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'dp_name' => 'Admin',
        ]);
        DB::table('departments')->insert([
            'dp_name' => 'IT',
        ]);
        DB::table('departments')->insert([
            'dp_name' => 'MATH',
        ]);
        DB::table('departments')->insert([
            'dp_name' => 'LAN',
        ]);
        DB::table('departments')->insert([
            'dp_name' => 'SCI',
        ]);
        DB::table('departments')->insert([
            'dp_name' => 'SPO',
        ]);
    }
}
