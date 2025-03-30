<?php

namespace Database\Seeders;

use App\Models\Barangay;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('psgc/barangays.json'));
        $barangays = json_decode($json, true);

        foreach ($barangays as $barangay) {
             // Skip if parent municipality doesn't exist
            if (!\App\Models\Municipality::where('code', $barangay['municipalityCode'])->exists()) {
                continue;
            }

            Barangay::create([
                'code' => $barangay['code'],
                'name' => $barangay['name'],
                'municipality_code' => $barangay['municipalityCode'], // ✅ Required
            ]);
        }
    }
}
