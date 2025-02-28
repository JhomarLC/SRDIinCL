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
        User::factory(20)->create();

        User::factory()->create([
            'first_name' => 'Jhomar',
            'middle_name' => 'Lapurga',
            'last_name' => 'Candelario',
            'suffix' => '',
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'first_name' => 'Jamaica',
            'middle_name' => 'Cawayan',
            'last_name' => 'Sambrano',
            'suffix' => '',
            'email' => 'aews@gmail.com',
            'role' => 'aews'
        ]);

    }
}
