<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employment_types')->insert([
            [
                'employment_name' => 'Job Order',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employment_name' => 'Permanent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employment_name' => 'Casual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}