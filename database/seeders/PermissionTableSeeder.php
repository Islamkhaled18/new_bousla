<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // admins
            'show all admins',
            'create admin',
            'update admin',
            'show admin',
            'delete admin',
            'admin status',

            // main categories
            'show all main categories',
            'create main category',
            'update main category',
            'delete main category',
            'main category status',

            // categories
            'show all categories',
            'create category',
            'update category',
            'delete category',
            'category status',

            // ads
            'show all ads',
            'create ad',
            'update ad',
            'delete ad',
            'ad status',

            // job titles
            'show all job titles',
            'create job title',
            'update job title',
            'delete job title',
            'job title status',

            //settings
            'edit settigns',

            //terms and conditions
            'show all terms and conditions',
            'create terms and conditions',
            'update terms and conditions',
            'delete terms and conditions',

            //about us
            'show all about us',
            'create about us',
            'update about us',
            'delete about us',

            //governorates
            'show all governorates',
            'create governorate',
            'update governorate',
            'delete governorate',
            'governorate status',

            //cities
            'show all cities',
            'create city',
            'update city',
            'delete city',
            'city status',

            //areas
            'show all areas',
            'create area',
            'update area',
            'delete area',
            'area status',
        ];



        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
