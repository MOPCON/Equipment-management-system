<?php

namespace App\Http\Controllers;

use App\Staff;
use App\RaiseEquipment;
use App\EquipmentBarcode;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    use ApiTrait;

    public function getBarcode(Request $request)
    {
        $staffs = Staff::all();
        $equipments = EquipmentBarcode::with('equipment')->get();
        $raiseEquipments = RaiseEquipment::all();
        $barcode = [];

        foreach ($staffs as $staff) {
            $barcode[] = [
                'display' => $staff->name,
                'barcode' => $staff->barcode,
            ];
        }

        foreach ($equipments as $equipment) {
            $barcode[] = [
                'display' => $equipment->equipment->name,
                'barcode' => $equipment->barcode,
            ];
        }

        foreach ($raiseEquipments as $raiseEquipment) {
            $barcode[] = [
                'display' => $raiseEquipment->name,
                'barcode' => $raiseEquipment->barcode,
            ];
        }

        if ($request->has('backup')) {
            for ($i = 1; $i <= $request->input('backup'); $i++) {
                $barcode[] = [
                    'display' => '備用',
                    'barcode' => 'BK' . str_pad(($i), 3, '0', STR_PAD_LEFT),
                ];
            }
        }

        $data = [
            'count'   => count($barcode),
            'barcode' => $barcode,
        ];

        return $this->returnSuccess('Success.', $data);
    }
}
