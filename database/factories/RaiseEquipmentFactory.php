<?php

use Faker\Generator as Faker;

$factory->define(App\RaiseEquipment::class, function (Faker $faker) {
    return [
        'name'     => $faker->company,
        'staff_id' => rand(1, App\Staff::orderBy('id', 'DESC')->first()->id),
        'status'   => 0,
    ];
});
