<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HeadOfFamilySeeder::class,
            FamilyMemberSeeder::class,
            SocialAssistanceSeeder::class,
            SocialAssistanceRecipientSeeder::class,
            EventSeeder::class,
            EventParticipantSeeder::class,
        ]);
    }
}
