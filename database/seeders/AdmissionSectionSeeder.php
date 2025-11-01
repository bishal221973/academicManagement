<?php

namespace Database\Seeders;

use App\Models\AdmissionSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdmissionSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                "name" => "Basic Information",
                "position" => 1,
            ],
            [
                "name" => "Academic Information",
                "position" => 2,
            ],
            [
                "name" => "Father's Information",
                "position" => 3,
            ],
            [
                "name" => "Mother's Information",
                "position" => 4,
            ],
            [
                "name" => "Address Information",
                "position" => 5,
            ],
            [
                "name" => "Previous School",
                "position" => 6,
            ]
        ];

        // Insert all records
        foreach ($datas as $data) {
            AdmissionSection::create($data);
        }
    }
}
