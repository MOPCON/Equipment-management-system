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
            Staff::create([
                'name' => 'Test' . $i,
                'email' => 'test' . $i . '@gmail.com',
                'phone' => '0900' . $i . $i . $i . $i * 9999,
                'group_id' => rand(0, 2),
            ]);
        }
    }
}
