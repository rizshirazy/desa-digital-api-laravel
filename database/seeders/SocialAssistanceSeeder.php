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
        $count = rand(10, 100);

        SocialAssistance::factory($count)->create();
    }
}
