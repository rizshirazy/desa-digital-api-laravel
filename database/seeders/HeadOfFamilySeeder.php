<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use Illuminate\Database\Seeder;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeadOfFamily::factory(15)
            ->create()
            ->each(function (HeadOfFamily $headOfFamily) {
                $headOfFamily->user?->assignRole('head-of-family');
            });
    }
}
