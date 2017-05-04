<?php

use Illuminate\Database\Seeder;
use App\User;

class InitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@local.host',
            'password' =>  'admin',
        ]);
    }
}
