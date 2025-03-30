<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Region;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $json = File::get(database_path('psgc/provinces.json'));
        $provinces = json_decode($json, true);

        foreach ($provinces as $province) {
            Province::create([
                'code' => $province['code'],
                'name' => $province['name'],
                'region_code' => $province['regionCode']
            ]);
        }
    }
}
