<?php

namespace Database\Seeders;

use App\Models\SocialAssistance;
use Illuminate\Database\Seeder;

class SocialAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialAssistance::factory(10)->create();
    }
}
