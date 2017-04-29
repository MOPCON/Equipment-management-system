<?php

use Illuminate\Database\Seeder;
use App\Equipment;
use App\EquipmentBarcode;

class EquipmentTableSeeder extends Seeder
{
    public function run()
    {
        Equipment::create([
            'name'       => 'machine',
            'source'     => '',
            'memo'       => '',
            'amount'     => rand(1, 10),
            'hasBarcode' => '1',
        ]);
        for ($i = 0; $i < 20; $i++) {
            $faker = Faker\Factory::create();
            Equipment::create([
                'name'       => $faker->name,
                'source'     => '',
                'memo'       => '',
                'amount'     => rand(1, 10),
                'hasBarcode' => '0',
            ]);
        }
        for ($i = 0; $i < 20; $i++) {
            $faker = Faker\Factory::create();
            EquipmentBarcode::create([
                'barcode'      => $faker->ean13,
                'equipment_id' => '1',
            ]);
        }
    }
}
