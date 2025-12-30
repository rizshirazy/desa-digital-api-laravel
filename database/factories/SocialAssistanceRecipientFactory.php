<?php

namespace Database\Factories;

use App\Models\HeadOfFamily;
use App\Models\SocialAssistance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\SocialAssistanceRecipient>
 */
class SocialAssistanceRecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'social_assistance_id' => SocialAssistance::factory(),
            'head_of_family_id' => HeadOfFamily::factory(),
            'amount' => $this->faker->numberBetween(500000, 5000000),
            'reason' => $this->faker->sentence(),
            'bank' => $this->faker->randomElement(['BCA', 'BRI', 'Mandiri', 'BNI']),
            'account_number' => $this->faker->numerify(str_repeat('#', 10)),
            'proof' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
