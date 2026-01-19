<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminTableSeeder::class,
            RolePermissionSeeder::class,
            PermissionTableSeeder::class,
            JobTitleTableSeeder::class,
            GovernorateTableSeeder::class,
            CityTableSeeder::class,
            AreaTableSeeder::class,
            MainCategoryTableSeeder::class,
            CategoryTableSeeder::class,
            AdTableSeeder::class,
            SettingTableSeeder::class,
            TermsConditionsTableSeeder::class,
            AboutUsTableSeeder::class,
            JoinRequestTableSeeder::class,
        ]);
    }
}
