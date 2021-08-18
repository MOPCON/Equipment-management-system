<?php

namespace Database\Seeders;

use App\Speaker;
use Illuminate\Database\Seeder;

class SpeakersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Speaker::factory()->times(10)->create();
    }
}
