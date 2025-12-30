<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\SocialAssistance>
 */
class SocialAssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = $this->faker->company();

        return [
            'name' => $this->faker->randomElement(['Bantuan Pangan', 'Bantuan Tunai', 'Bantuan Bahan Bakar Bersubsidi', 'Bantuan Kesehatan']) . ' ' . $company,
            'thumbnail' => $this->faker->imageUrl(),
            'category' => $this->faker->randomElement(['staple', 'health', 'food', 'housing', 'cash']),
            'amount' => $this->faker->randomFloat(2, 500000, 5000000),
            'provider' => $company,
            'description' => $this->faker->paragraph(),
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
