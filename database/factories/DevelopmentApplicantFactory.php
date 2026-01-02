<?php

namespace Database\Factories;

use App\Models\Development;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\DevelopmentApplicant>
 */
class DevelopmentApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'development_id' => Development::factory(),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['approved', 'pending', 'rejected']),
        ];
    }
}
