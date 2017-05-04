<?php

use Illuminate\Database\Seeder;
use App\Group;
use App\Staff;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name' => '場務組'
        ]);
        Group::create([
            'name' => '行政組'
        ]);
        Group::create([
            'name' => '議程組'
        ]);
        for ($i = 0; $i < 40; $i++) {
            $faker = Faker\Factory::create();
            Staff::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->e164PhoneNumber,
                'group_id' => rand(1, 3),
            ]);
        }
    }
}
