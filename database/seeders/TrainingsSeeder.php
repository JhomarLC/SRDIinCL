<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trainings')->insert([
            [
                'title' => 'Production of High-Quality Inbred Rice & Seeds, and Farm Mechanization',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pest and Nutrient Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Refresher Course for Rice Trainers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hybrid Rice Seed Production',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rice Specialist Training Course',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Others',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}