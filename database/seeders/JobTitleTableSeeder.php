<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_titles')->delete();

        $jobs = [
            [
                'id'      => 1,
                'name'    => 'عميل',
                'name_en' => 'عميل',
                'slug' => 'عميل',

            ],
            [
                'id'      => 2,
                'name'    => 'طبيب',
                'name_en' => 'طبيب',
                'slug' => 'طبيب',
            ],
            [
                'id'      => 3,
                'name'    => 'نجار',
                'name_en' => 'نجار',
                'slug' => 'نجار',
            ],

        ];

        foreach ($jobs as $job) {
            JobTitle::create($job);
        }
    }
}
