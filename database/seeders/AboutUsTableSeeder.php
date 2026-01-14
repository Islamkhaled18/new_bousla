<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AboutUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutUs::truncate();

        $aboutuses = [
            [
                'id'   => 1,
                'text' => 'شروط واحكام شروط واحكام شروط واحكام ',
                'text_en' => 'شروط واحكام شروط واحكام شروط واحكام ',
                'uuid'    => Str::uuid()->toString(),

            ],

        ];

        foreach ($aboutuses as $aboutus) {
            AboutUs::create($aboutus);
        }
    }
}
