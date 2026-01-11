<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ads')->delete();

        $ads = [
            [
                'id'       => 1,
                'name'     => 'اعلان اول',
                'name_en'  => 'first ad',
                'slug'  => 'first ad',
            ],
            [
                'id'       => 2,
                'name'     => 'اعلان ثاني',
                'name_en'  => 'second ad',
                'slug'  => 'second ad',
            ],

        ];

        foreach ($ads as $ad) {
            Ad::create($ad);
        }
    }
}
