<?php

namespace Database\Seeders;

use App\Models\TermCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TermsConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TermCondition::truncate();
        $terms_conditions = [
            [
                'id'      => 1,
                'name'    => 'شروط واحكام شروط واحكام شروط واحكام ',
                'name_en' => 'terms and conditions and conditions and conditions ',
                'uuid'    => Str::uuid()->toString(),

            ],

        ];

        foreach ($terms_conditions as $terms_condition) {
            TermCondition::create($terms_condition);
        }
    }
}
