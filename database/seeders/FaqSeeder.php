<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->delete();

        $faqs = [
            [
                'id'       => 1,
                'question'     => 'السؤال الاول',
                'answer'  => 'الاجابة الاول',
                'uuid'    => Str::uuid()->toString(),
            ],
            [
                'id'       => 2,
                'question'     => 'السؤال الثاني',
                'answer'  => 'الاجابة الثاني',
                'uuid'    => Str::uuid()->toString(),
            ]

        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
