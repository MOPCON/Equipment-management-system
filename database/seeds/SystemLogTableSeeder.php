<?php

use App\SystemLog;
use App\SystemLogType;
use Illuminate\Database\Seeder;

class SystemLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemLogType::create([
            'name' => '類別一'
        ]);
        SystemLogType::create([
            'name' => '類別二'
        ]);

        $devices = ['iphone', 'android', 'desktop'];
        $browsers = ['ie', 'chrome', 'safari'];

        for ($i = 0; $i < 5; $i++) {
            $faker = Faker\Factory::create('zh_TW');
            SystemLog::create([
                'user_id' => rand(1, 6),
                'type_id' => rand(1, 2),
                'content' => $faker->sentence(),
                'ip' => $faker->ipv4,
                'device' => $devices[rand(0, 2)],
                'browser' => $browsers[rand(0, 2)],
            ]);
        }
    }
}
