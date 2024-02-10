<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'Keyname'   => 'SCHOOL_NAME',
                'Keyvalue'  => 'North Eastern Mindanao State University',
            ],
            [
                'Keyname'   => 'CAMPUS_NAME',
                'Keyvalue'  => 'LIANGA CAMPUS',
            ],
            [
                'Keyname'   => 'CAMPUS_ADDRESS',
                'Keyvalue'  => 'Lianga, Surigao del Sur',
            ],
            [
                'Keyname'   => 'HR',
                'Keyvalue'  => 'FRENZY KHARISMA V. BACATAN, RPm',
            ],
            [
                'Keyname'   => 'HR_POSITION',
                'Keyvalue'  => 'HRMO 1',
            ],
            [
                'Keyname'   => 'ASSISTANT_CAMPUS_DIRECTOR',
                'Keyvalue'  => 'FAITH P. VILLANUEVA, Ph.D. (CAR)',
            ],
            [
                'Keyname'   => 'ASSISTANT_CAMPUS_DIRECTOR_POSITION',
                'Keyvalue'  => 'Assistant Campus Director',
            ],
            [
                'Keyname'   => 'CAMPUS_DIRECTOR',
                'Keyvalue'  => 'CYNTHIA P. SAJOT, PH. D.',
            ],
            [
                'Keyname'   => 'CAMPUS_DIRECTOR_POSITION',
                'Keyvalue'  => 'Campus Director',
            ],
            [
                'Keyname'   => 'DFIMES_CHAIRMAN',
                'Keyvalue'  => 'FABIO C. RUAZA JR., Ph.D.',
            ],
            [
                'Keyname'   => 'DFIMES_CHAIRMAN_POSITION',
                'Keyvalue'  => 'Dfimes Chairman',
            ],
            [
                'Keyname'   => 'DGTT_CHAIRMAN',
                'Keyvalue'  => 'ERMELYN M. BUSTILLO, Ph.D.',
            ],
            [
                'Keyname'   => 'DGTT_CHAIRMAN_POSITION',
                'Keyvalue'  => 'DGTT Program Chairman',
            ],
        ];

        foreach($data as $key => $value){
            Settings::firstOrCreate([
                'Keyname' => $value['Keyname'],
                'Keyvalue' => $value['Keyvalue'],
            ]);
        }
    }
}
