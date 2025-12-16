<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $course = Course::inRandomOrder()->first() ?? Course::factory()->create();

        // Predefined group names
        $predefinedNames = [
            'Army', 'Police'
        ];

        // Get existing group names already used for this course
        $usedNames = Group::pluck('name')->toArray();

        // Filter out used names
        $availableNames = array_diff($predefinedNames, $usedNames);

        if (!empty($availableNames)) {
            // Use a remaining predefined name
            $name = $this->faker->randomElement($availableNames);
        } else {
            // All names taken for this course → generate a random unique one
            $name = 'Group ' . ucfirst($this->faker->unique()->word());
        }

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'position' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->boolean(90),
        ];
    }
}
