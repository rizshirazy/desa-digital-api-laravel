<?php

namespace Database\Seeders;

use App\Models\Development;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = rand(10, 100);

        Development::factory($count)->create();
    }
}
