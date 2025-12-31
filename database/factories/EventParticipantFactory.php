<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\HeadOfFamily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\EventParticipant>
 */
class EventParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $pricePerTicket = $this->faker->numberBetween(10000, 200000);

        return [
            'event_id' => Event::factory(),
            'head_of_family_id' => HeadOfFamily::factory(),
            'quantity' => $quantity,
            'total_price' => $quantity * $pricePerTicket,
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
