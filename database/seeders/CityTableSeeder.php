<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->delete();

        $cities = [
            [
                'id'             => 1,
                'name'           => 'مدينة نصر',
                'name_en'        => 'City of Nasser',
                'slug'        => 'City of Nasser',
                'governorate_id' => 1,
            ],
            [
                'id'             => 2,
                'name'           => 'المحلة الكبرى',
                'name_en'        => 'The Grand City',
                'slug'        => 'The Grand City',
                'governorate_id' => 2,
            ],

        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
