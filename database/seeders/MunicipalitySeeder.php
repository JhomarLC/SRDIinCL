<?php

namespace Database\Seeders;

use App\Models\Municipality;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $json = File::get(database_path('psgc/municipalities.json'));
        $municipalities = json_decode($json, true);

        foreach ($municipalities as $municipality) {
            Municipality::create([
                'code' => $municipality['code'],
                'name' => $municipality['name'],
                'province_code' => $municipality['provinceCode'],
            ]);
        }
    }
}
