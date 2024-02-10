<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\AcademicYearSeeder;
use Database\Seeders\CriteriaQuestionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleSeeder::class,
            SettingSeeder::class,
            AcademicYearSeeder::class,
            CriteriaQuestionSeeder::class,
            DepartmentFacultySeeder::class,
            AdminSeeder::class
        ]);
    }
}
