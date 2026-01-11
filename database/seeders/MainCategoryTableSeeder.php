<?php

namespace Database\Seeders;

use App\Models\MainCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('main_categories')->delete();

        $mainCategories = [
            [
                'id'      => 1,
                'name'    => 'Bousla Medical',
                'name_en' => 'Bousla Medical',
                'slug'    => 'bousla-medical',
                'image'   => 'bousla/mainCategories/1.jpg',
            ],
            [
                'id'      => 2,
                'name'    => 'Bousla Home Services',
                'name_en' => 'Bousla Home Services',
                'slug'    => 'bousla-home-services',
                'image'   => 'bousla/mainCategories/2.jpg',

            ],

        ];

        foreach ($mainCategories as $manCategory) {
            MainCategory::create($manCategory);
        }
    }
}
