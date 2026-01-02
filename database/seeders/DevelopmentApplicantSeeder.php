<?php

namespace Database\Seeders;

use App\Models\Development;
use App\Models\DevelopmentApplicant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopmentApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developments = Development::all();
        $users = User::all();

        if ($developments->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($developments as $development) {
            $count = rand(2, 5);
            $selectedUsers = $users->shuffle()->take($count);

            foreach ($selectedUsers as $user) {
                DevelopmentApplicant::factory()->create([
                    'development_id' => $development->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
