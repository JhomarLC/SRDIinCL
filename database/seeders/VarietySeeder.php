<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VarietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('seeders/data/varieties.csv');

        if (!File::exists($filePath)) {
            $this->command->error("CSV file not found at: $filePath");
            return;
        }

        $data = array_map('str_getcsv', file($filePath));
        $header = array_map('trim', array_map('strtolower', $data[0]));
        unset($data[0]); // remove header row

        $seen = [];

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            // Skip if name is already processed (deduplication)
            if (in_array($rowData['name'], $seen)) {
                continue;
            }

            $seen[] = $rowData['name'];

            DB::table('varieties')->insert([
                'name' => $rowData['name'],
                'local_name' => $rowData['local_name'] !== '' ? $rowData['local_name'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Varieties seeded successfully.');
    }
}
