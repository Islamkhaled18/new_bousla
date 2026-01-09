<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('governorates')->delete();

        $governorates = [
            [
                'id'      => 1,
                'name'    => 'القاهرة',
                'name_en' => 'Cairo',
                'slug' => 'Cairo',
            ],
            [
                'id'      => 2,
                'name'    => 'الغربيه',
                'name_en' => 'Gharbia',
                'slug' => 'Gharbia',
            ],

        ];

        foreach ($governorates as $governorate) {
            Governorate::create($governorate);
        }
    }
}
