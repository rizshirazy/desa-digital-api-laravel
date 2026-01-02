<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Development>
 */
class DevelopmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->addDays(rand(1, 30));
        $endDate = (clone $startDate)->addDays(rand(10, 60));

        return [
            'name' => $this->faker->randomElement(['Pembangunan Jalan', 'Perbaikan Jalan', 'Pembuatan Jembatan']) . ' ' . $this->faker->city(),
            'thumbnail' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph(),
            'person_in_charge' => $this->faker->name(),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'amount' => $this->faker->randomFloat(2, 10000000, 100000000),
            'status' => $this->faker->randomElement(['ongoing', 'completed']),
        ];
    }
}
