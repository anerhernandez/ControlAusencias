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
    }
}
