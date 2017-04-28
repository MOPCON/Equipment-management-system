<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == "prod") {
            $this->call(InitTableSeeder::class);
        } else {
            $this->call(UsersTableSeeder::class);
            $this->call(StaffTableSeeder::class);
        }
    }
}
