<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'academic_year'         => '2023-2024',
                'semester'              => '2',
                'isDefault'             => true,
                'evaluation_status'     => '0',
            ],
            [
                'academic_year'         => '2024-2025',
                'semester'              => '1',
                'isDefault'             => false,
                'evaluation_status'     => '0',
            ],
        ];

        foreach($data as $key => $value){
            AcademicYear::firstOrCreate([
                'academic_year'         => $value['academic_year'],
                'semester'              => $value['semester'],
                'isDefault'             => $value['isDefault'],
                'evaluation_status'     => $value['evaluation_status'],
            ]);
        }
    }
}
