<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use App\Models\HeadOfFamily;
use Illuminate\Database\Seeder;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headFamilies = HeadOfFamily::all();

        foreach ($headFamilies as $headFamily) {
            FamilyMember::factory()
                ->count(rand(3, 5))
                ->create([
                    'head_of_family_id' => $headFamily->id,
                ]);
        }
    }
}
