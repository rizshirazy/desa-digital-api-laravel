<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\HeadOfFamily>
 */
class HeadOfFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'profile_picture' => $this->faker->imageUrl(),
            'identity_number' => $this->faker->unique()->numerify(str_repeat('#', 16)),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => Carbon::now()->subYears(rand(20, 60))->subDays(rand(0, 365)),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'occupation' => $this->faker->jobTitle(),
            'marital_status' => $this->faker->randomElement(['single', 'married', 'divorced']),
        ];
    }
}
