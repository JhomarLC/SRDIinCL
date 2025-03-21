<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EmploymentType;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10000)->create();

        User::factory()->create([
            'first_name' => 'Jhomar',
            'middle_name' => 'Lapurga',
            'last_name' => 'Candelario',
            'suffix' => '',
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ]);

        $this->call([
            PositionSeeder::class, // Register the custom seeder
            EmploymentTypeSeeder::class, // Register the custom seeder
            TrainingsSeeder::class, // Register the custom seeder
        ]);
    }
}
