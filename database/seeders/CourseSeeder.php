<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
        'BCA', 'MCA', 'BBA', 'MBA', 'BBS', 'MBS',
        'CSIT', 'BA', 'MA', 'BED', 'BHM', 'BBA IT',
        'BE Computer', 'Civil Engineering', 'Mechanical Engineering',
        'Electrical Engineering', 'Architecture', 'Pharmacy',
        'Nursing', 'Law', 'Journalism', 'Mass Communication',
        'Psychology', 'Sociology', 'Economics', 'Political Science',
        'History', 'Geography', 'Environmental Science',
        'Biology', 'Chemistry', 'Physics', 'Mathematics',
        'English Literature', 'Education', 'Fine Arts', 'Music',
        'Theatre Arts', 'Film Studies', 'Anthropology', 'Linguistics',
    ];

    foreach ($courses as $index => $name) {
        Course::create([
            'name' => $name,
            'code' => strtoupper(substr($name, 0, 3)) . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'fees' => fake()->numberBetween(20000, 100000),
            'description' => fake()->sentence(),
            'credits' => fake()->randomElement([3, 4, 5]),
            'position' => $index + 1,
            'status' => true,
        ]);
    }
    }
}
