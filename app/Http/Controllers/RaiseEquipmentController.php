<?php

namespace App\Http\Controllers;

use App\RaiseEquipment;
use Illuminate\Http\Request;
use App\Http\Requests\RaiseEquipmentRequest;

class RaiseEquipmentController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $status = $request->input('status', [0, 1, 2, 3]);
        $barcode = $request->input('barcode', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 15);
        $raiseEquipment = RaiseEquipment::whereIn('status', $status)
            ->Where(function ($query) use ($barcode) {
                $query->orWhere('barcode', 'LIKE', '%' . $barcode . '%');
            })
            ->orderBy($order_field, $order_method)
            ->paginate($limit);

        return $this->returnSuccess('Success.', $raiseEquipment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RaiseEquipmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RaiseEquipmentRequest $request)
    {
//        dd($request->all());
        $raiseEquipment = RaiseEquipment::create($request->only('name', 'staff_id'));

        return $this->returnSuccess('已新增', $raiseEquipment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RaiseEquipment  $raiseEquipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RaiseEquipment $raiseEquipment)
    {
        return $this->returnSuccess('Show success', $raiseEquipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RaiseEquipmentRequest $request
     * @param  \App\RaiseEquipment          $raiseEquipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RaiseEquipmentRequest $request, RaiseEquipment $raiseEquipment)
    {
        $raiseEquipment->update($request->only('name', 'staff_id', 'barcode', 'status'));

        return $this->returnSuccess('已編輯', $raiseEquipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RaiseEquipment  $raiseEquipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RaiseEquipment $raiseEquipment)
    {
        if ($raiseEquipment->status != '0') {
            return $this->return400Response('無法刪除');
        }

        $raiseEquipment->delete();

        return $this->returnSuccess('已刪除');
    }

    public function changeStatus(RaiseEquipment $raiseEquipment, $status)
    {
        $raiseEquipment->status = $status;
        $raiseEquipment->save();

        return $this->returnSuccess('已改變狀態', $raiseEquipment);
    }
}
