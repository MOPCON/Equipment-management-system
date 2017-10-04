<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\EquipmentBarcode;
use App\Http\Controllers\ApiTrait;

class BarcodeController extends Controller
{

    use ApiTrait;

    public function getBarcode(Request $request)
    {
        $staff = Staff::pluck('barcode')->toArray();
        $equipmentbarcode = EquipmentBarcode::pluck('barcode')->toArray();

        if ($request->has('backup')) {
            $backup = [];
            for ($i = 1; $i <= $request->input('backup'); $i++) {
                $backup[] = 'BK' . str_pad(($i), 5, '0', STR_PAD_LEFT);
            }
            $barcode = array_merge($staff, $equipmentbarcode, $backup);
        } else {
            $barcode = array_merge($staff, $equipmentbarcode);
        }

        $data = [
            'count'   => count($barcode),
            'barcode' => $barcode,
        ];

        return $this->returnSuccess('Success.', $data);
    }
}
