<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentBarcode;
use Illuminate\Http\Request;
use App\Http\Requests\EquipmentRequest;
use App\Http\Controllers\ApiTrait;

class EquipmentController extends Controller
{

    use ApiTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        if ($request->input('all', false)) {
            $equipment = Equipment::orderBy($order_field, $order_method)->get();
        } else {
            $limit = $request->input('limit', 15);
            $equipment = Equipment::Where(function($query) use ($search) {
                $query->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('memo', 'LIKE', '%' . $search . '%')
                    ->orWhere('source', 'LIKE', '%' . $search . '%');
            })
                ->orderBy($order_field, $order_method)
                ->paginate($limit);
        }


        return $this->returnSuccess('Success.', $equipment);
    }

    /**
     * @param EquipmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EquipmentRequest $request)
    {
        $equipment = Equipment::create($request->all());

        if ($equipment->hasBarcode) {
            for ($i = 0; $i < $equipment->amount; $i++) {
                EquipmentBarcode::create([
                    'barcode'      => $equipment->prefix .
                        str_pad(($i), 5, '0', STR_PAD_LEFT),
                    'equipment_id' => $equipment->id,
                ]);
            }
        }

        return $this->returnSuccess('Store success.', $equipment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipment $equipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Equipment $equipment)
    {
        $equipment->barcode;
        return $this->returnSuccess('Show success.', $equipment);
    }

    /**
     * @param EquipmentRequest $request
     * @param Equipment        $equipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EquipmentRequest $request, Equipment $equipment)
    {
        $equipment->update($request->all());

        EquipmentBarcode::where('equipment_id', $equipment->id)->delete();

        if ($equipment->hasBarcode) {
            for ($i = 0; $i < $equipment->amount; $i++) {
                EquipmentBarcode::create([
                    'barcode'      => $equipment->prefix .
                        str_pad(($i), 5, '0', STR_PAD_LEFT),
                    'equipment_id' => $equipment->id,
                ]);
            }
        }

        return $this->returnSuccess('Update success.', $equipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return $this->returnSuccess('Delete success.');
    }
}
