<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $users = [
            [
                'id'       => 1,
                'first_name'     => 'Islam',
                'last_name'     => 'Khaled',
                'slug'     => 'Islam-Khaled',
                'email'    => 'islam.hegazy72@gmail.com',
                'password' => bcrypt('123456789'),
                'phone'    => '01015949894',
                'type'    => 'admin',
            ],
            [
                'id'       => 2,
                'first_name'     => 'mohamed',
                'last_name'     => 'elabasy',
                'slug'     => 'mohamed-elabasy',

                'email'    => 'mohamed.elabasy@gmail.com',
                'password' => bcrypt('123456789'),
                'phone'    => '01228772551',
                'type'    => 'admin',
            ],
            [
                'id'       => 3,
                'type' => 'client',
                'first_name' => 'sameh',
                'last_name' => 'kamel',
                'slug' => 'sameh-kamel',
                'phone' => '01121000240',
                'address' => 'البندر - امتداد شارع جامع عبد الحي خليل بجوار مول الشيشيني',
                'email' => 'sameh.kamel@gmail.com',
            ],
            [
                'id'       => 4,
                'type' => 'doctor',
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

        foreach ($users as $user) {
            $user = User::create($user);
            $user->regenerateNickname();
        }
    }
}
