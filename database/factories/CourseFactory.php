<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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

        // Pick one randomly
        $name = $this->faker->unique()->randomElement($courses);

        return [
            'name' => $name,
            'code' => strtoupper(substr($name, 0, 3)) . '-' . $this->faker->unique()->numerify('###'),
            'fees' => $this->faker->numberBetween(20000, 100000),
            'description' => $this->faker->sentence(),
            'credits' => $this->faker->randomElement([3, 4, 5]),
            'position' => $this->faker->numberBetween(1, 14),
            'status' => $this->faker->boolean(90), // 90% active
        ];
    }
}
