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
            'amount'     => 20,
            'hasBarcode' => '1',
            'prefix'     => 'EQ',
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
            EquipmentBarcode::create([
                'barcode'      => 'EQ' . str_pad(($i), 5, '0', STR_PAD_LEFT),
                'equipment_id' => '1',
            ]);
        }
    }
}
