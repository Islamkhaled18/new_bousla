<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         PrivacyPolicy::truncate();

        $privacy_policies = [
            [
                'id'   => 1,
                'text' => 'سياسة خصوصية سياسة خصوصية سياسة خصوصية',
                'text_en' => 'سياسة خصوصية سياسة خصوصية سياسة خصوصية',
                'uuid'    => Str::uuid()->toString(),

            ],

        ];

        foreach ($privacy_policies as $privacy_policy) {
            PrivacyPolicy::create($privacy_policy);
        }
    }
}
