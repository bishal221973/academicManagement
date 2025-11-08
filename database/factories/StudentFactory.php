<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Group;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'roll_number' => $this->faker->unique()->numerify('R####'),
            'name' => $this->faker->name(),
            'registration_number' => $this->faker->unique()->numerify('REG####'),
            'registration_date' => $this->faker->date(),
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'religion' => $this->faker->randomElement(['Islam', 'Christianity', 'Hinduism', 'Buddhism', 'Other']),
            'cast' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'national_id' => $this->faker->unique()->numerify('NID#####'),

            // Foreign keys (if related models exist)
            'course_id' => Course::inRandomOrder()->value('id') ?? Course::factory(),
            'academic_year_id' => 1,
            'section_id' => Section::inRandomOrder()->value('id') ?? Section::factory(),
            'group_id' => Group::inRandomOrder()->value('id') ?? Group::factory(),

            'father_name' => $this->faker->name('male'),
            'father_phone' => $this->faker->phoneNumber(),
            'father_education' => $this->faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
            'father_profession' => $this->faker->jobTitle(),

            'mother_name' => $this->faker->name('female'),
            'mother_phone' => $this->faker->phoneNumber(),
            'mother_education' => $this->faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
            'mother_profession' => $this->faker->jobTitle(),

            'present_address' => $this->faker->address(),
            'permanent_address' => $this->faker->address(),

            'prev_school' => $this->faker->company(),
            'prev_class' => $this->faker->randomElement(['Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10']),
            'transfer_certificate' => $this->faker->optional()->word(),

            'profile' => $this->faker->imageUrl(200, 200, 'people'),
            'status' => $this->faker->boolean(90), // 90% active
            'is_transfered' => $this->faker->boolean(10), // 10% transferred
            'admission_fee'=>rand(11111,99999)

        ];
    }
}
