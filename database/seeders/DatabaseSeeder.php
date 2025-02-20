<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jhomar L. Candelario',
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Jamaica C. Sambrano',
            'email' => 'aews@gmail.com',
            'role' => 'aews'
        ]);

    }
}