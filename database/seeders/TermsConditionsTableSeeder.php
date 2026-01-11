<?php

namespace Database\Seeders;

use App\Models\TermCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermsConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms_conditions')->delete();

        $terms_conditions = [
            [
                'id'      => 1,
                'name'    => 'شروط واحكام شروط واحكام شروط واحكام ',
                'name_en' => 'terms and conditions and conditions and conditions ',
            ],

        ];

        foreach ($terms_conditions as $terms_condition) {
            TermCondition::create($terms_condition);
        }
    }
}
