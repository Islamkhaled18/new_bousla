<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminTableSeeder extends Seeder
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
            ],
            [
                'id'       => 2,
                'first_name'     => 'mohamed',
                'last_name'     => 'elabasy',
                'slug'     => 'mohamed-elabasy',

                'email'    => 'mohamed.elabasy@gmail.com',
                'password' => bcrypt('123456789'),
                'phone'    => '01228772551',
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
