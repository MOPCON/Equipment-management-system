<?php

namespace Database\Factories;

use App\RaiseEquipment;
use App\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaiseEquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RaiseEquipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => $this->faker->company,
            'staff_id' => rand(1, Staff::orderBy('id', 'DESC')->first()->id),
            'status'   => 0,
        ];
    }
}
