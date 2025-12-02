<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Students>
 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'email' => $this->faker->safeEmail(),
            'age' => $this->faker->randomNumber(2 true),
            'course' => $this->faker->sentence,
        ];
        $this->call(PostSeeder::class);
    }
}
