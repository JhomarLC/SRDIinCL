<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('positions')->insert([
            [
                'position_name' => 'Provincial Agriculturist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position_name' => 'Municipal/City Agriculturist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position_name' => 'Rice AEW',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}