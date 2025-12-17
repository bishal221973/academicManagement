<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = Course::inRandomOrder()->first() ?? Course::factory()->create();

        // Predefined section names
        $predefinedNames = ['Section A', 'Section B', 'Section C', 'Section D'];

        // Find which section names are already used for this course
        $usedNames = Section::where('course_id', $course->id)->pluck('name')->toArray();

        // Determine available section names for this course
        $availableNames = array_diff($predefinedNames, $usedNames);

        if (!empty($availableNames)) {
            // Pick one unused name
            $name = $this->faker->randomElement($availableNames);
        } else {
            // All used → generate a random unique one
            $name = 'Section ' . strtoupper($this->faker->unique()->lexify('??')) . $this->faker->randomDigit();
        }

        return [
            'course_id' => rand(1,8),
            'name' => $name,
            'description' => $this->faker->sentence(),
            'position' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->boolean(90),
        ];
    }
}
