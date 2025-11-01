<?php

namespace Database\Seeders;

use App\Models\AdmissionField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdmissionFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $datas = [
            [
                "admission_section_id"=>1,
                "name" => "Roll Number",
                "position" => 1,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Name",
                "position" => 2,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Registration No.",
                "position" => 3,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Registration Date",
                "position" => 4,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Birth Date",
                "position" => 5,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Gender",
                "position" => 6,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Religion",
                "position" => 7,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Cast",
                "position" => 8,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Phone",
                "position" => 9,
            ],
            [
                "admission_section_id"=>1,
                "name" => "Email",
                "position" => 10,
            ],
            [
                "admission_section_id"=>1,
                "name" => "National ID",
                "position" => 11,
            ],


            // ==================
            [
                "admission_section_id"=>2,
                "name" => "Course",
                "position" => 1,
            ],
            [
                "admission_section_id"=>2,
                "name" => "Section",
                "position" => 2,
            ],
            [
                "admission_section_id"=>2,
                "name" => "Group",
                "position" => 3,
            ],
            

            // ==================
            [
                "admission_section_id"=>3,
                "name" => "Father Name",
                "position" => 1,
            ],
            [
                "admission_section_id"=>3,
                "name" => "Phone",
                "position" => 2,
            ],
            [
                "admission_section_id"=>3,
                "name" => "Education",
                "position" => 3,
            ],
            [
                "admission_section_id"=>3,
                "name" => "Profession",
                "position" => 4,
            ],

            // ==================
            [
                "admission_section_id"=>4,
                "name" => "Mother Name",
                "position" => 1,
            ],
            [
                "admission_section_id"=>4,
                "name" => "Phone",
                "position" => 2,
            ],
            [
                "admission_section_id"=>4,
                "name" => "Education",
                "position" => 3,
            ],
            [
                "admission_section_id"=>4,
                "name" => "Profession",
                "position" => 4,
            ],

             // ==================
            [
                "admission_section_id"=>5,
                "name" => "Present",
                "position" => 1,
            ],
            [
                "admission_section_id"=>5,
                "name" => "Permanent",
                "position" => 2,
            ],
            // ==================
            [
                "admission_section_id"=>6,
                "name" => "School Name",
                "position" => 1,
            ],
            [
                "admission_section_id"=>6,
                "name" => "Class",
                "position" => 2,
            ],
            
            
            
        ];
        foreach ($datas as $data) {
            AdmissionField::create($data);
        }
    }
}
