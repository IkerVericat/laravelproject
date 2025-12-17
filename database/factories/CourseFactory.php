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
        return [
            'name' => $this->faker->randomElement(['Mathematics 101', 'Physics 201', 'Chemistry 301', 'Biology 401', 'History 101', 'Literature 201']),
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()?->id,
        ];
    }
}
