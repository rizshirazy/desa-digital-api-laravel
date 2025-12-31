<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use App\Models\SocialAssistance;
use App\Models\SocialAssistanceRecipient;
use Illuminate\Database\Seeder;

class SocialAssistanceRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headFamilies = HeadOfFamily::all();
        $socialAssistances = SocialAssistance::all();

        if ($headFamilies->isEmpty() || $socialAssistances->isEmpty()) {
            return;
        }

        foreach ($headFamilies as $headFamily) {
            $recipientsCount = rand(1, 2);
            $selectedAssistances = $socialAssistances->shuffle()->take($recipientsCount);

            foreach ($selectedAssistances as $assistance) {
                SocialAssistanceRecipient::factory()->create([
                    'head_of_family_id' => $headFamily->id,
                    'social_assistance_id' => $assistance->id,
                ]);
            }
        }
    }
}
