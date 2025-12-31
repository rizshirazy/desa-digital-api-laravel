<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\HeadOfFamily;
use Illuminate\Database\Seeder;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $families = HeadOfFamily::all();

        if ($events->isEmpty() || $families->isEmpty()) {
            return;
        }

        foreach ($events as $event) {
            $participantCount = rand(2, 5);

            EventParticipant::factory()
                ->count($participantCount)
                ->create([
                    'event_id' => $event->id,
                    'head_of_family_id' => $families->random()->id,
                ]);
        }
    }
}
