<?php

namespace Database\Seeders;

use App\Models\JoinRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JoinRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('join_requests')->delete();

        $join_requests = [
            [
                'status' => 'pending',
                'first_name' => 'دكتور احمد ',
                'last_name' => 'عبد اللطيف',
                'slug' => 'dr-ahmed',
                'phone' => '01555987642',
                'address' => 'البندر - امتداد شارع جامع عبد الحي خليل بجوار مول الشيشيني',
                'email' => 'ahmed@gmail.com',
                'about_me' => 'دكتور تغذيه وعلاج طبيعي',
                'id_number' => '12345678912345',
                'job_title_id' => 2,
                'area_id' => 2,
                'organization_name' => 'المركز الفرنسي',
                'organization_phone_first' => '0402434576',
                'organization_phone_second' => '0402438543',
                'organization_phone_third' => '0402431241',
                'organization_location_url' => 'https://maps.app.goo.gl/kToXTgBFzWDNw49R7?g_st=aw',
                'building_number' => 2,
                'floor_number' => 2,
                'apartment_number' => 2,
            ],


        ];

        foreach ($join_requests as $join_request) {
            JoinRequest::create($join_request);
        }
    }
}
