<?php

namespace Database\Seeders;

use App\Models\Region;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $json = File::get(database_path('psgc/regions.json'));
        $regions = json_decode($json, true);

        foreach ($regions as $region) {
            Region::create([
                'code' => $region['code'],
                'name' => $region['name'], // e.g., "Ilocos Region"
                'region_name' => $region['regionName'], // e.g., "Region I"
            ]);
        }
    }
}
