<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::now()->addDays(rand(1, 60));

        return [
            'name' => $this->faker->sentence(3),
            'thumbnail' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10000, 200000),
            'date' => $date->toDateString(),
            'time' => $date->format('H:i:s'),
            'is_active' => $this->faker->boolean(85),
        ];
    }
}
