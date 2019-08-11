<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use App\Http\Requests\EquipmentRequest;

class EquipmentController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    /**
     * EquipmentController constructor.
     */
    public function __construct()
    {
        $this->checkPermissionApiResource();
    }

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
            $equipment = Equipment::Where(function ($query) use ($search) {
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

        $equipment->setBarcode();

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

        $equipment->setBarcode();

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
