<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->delete();

        $areas = [
            [
                'id'      => 1,
                'name'    => 'الحى العاشر',
                'name_en' => 'The tenth district',
                'slug' => 'The tenth district',
                'city_id' => 1,
            ],
            [
                'id'      => 2,
                'name'    => 'الشعبيه',
                'name_en' => 'The Shabieh',
                'slug' => 'The Shabieh',
                'city_id' => 2,
            ],

        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
