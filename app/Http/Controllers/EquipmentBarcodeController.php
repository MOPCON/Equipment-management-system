<?php

namespace App\Http\Controllers;

use App\EquipmentBarcode;
use Illuminate\Http\Request;
use App\Services\ApiService;

class EquipmentBarcodeController extends Controller
{
    /**
     * @param Request $request
     * @return App\Services\ApiService
     */
    public function index(Request $request)
    {
        $status = $request->input('status', '-1');
        $search = $request->input('search', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 15);
        $barcode = EquipmentBarcode::Where(function($query) use ($search, $status) {
            if ($status != '-1') {
                $query->where('status', $status);
            }
            $query->Where('barcode', 'LIKE', '%' . $search . '%');
        })->orderBy($order_field, $order_method)
            ->paginate($limit);

        return ApiService::returnApiResponse('Success.', $barcode);
    }
}
