<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Http\Controllers\ApiTrait;

class StaffController extends Controller
{

    use ApiTrait;

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $group_id = $request->input('group_id', Group::getGroupIdArray());
        $search = $request->input('search', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        if ($request->input('all', false)) {
            $staff = Staff::orderBy($order_field, $order_method)->get();
        } else {
            $limit = $request->input('limit', 15);
            $staff = Staff::whereIn('group_id', $group_id)
                ->Where(function($query) use ($search) {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('phone', 'LIKE', '%' . $search . '%');
                })
                ->orderBy($order_field, $order_method)
                ->paginate($limit);
        }
        return $this->returnSuccess('Success.', $staff);
    }

    /**
     * @param StaffRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StaffRequest $request)
    {
        $staff = Staff::create($request->only(['name', 'email', 'phone', 'group_id', 'barcode']));

        switch ((string) $request->input('role')) {
            case '1':
                $staff->group->deputy_manager = $staff->id;
                $staff->group->save();
                break;
            case '2':
                $staff->group->manager = $staff->id;
                $staff->group->save();
                break;
        }

        return $this->returnSuccess('Store success.', $staff);
    }

    /**
     * @param Staff $staff
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Staff $staff)
    {
        return $this->returnSuccess('Show success.', $staff);
    }

    /**
     * @param StaffRequest $request
     * @param Staff        $staff
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $staff->update($request->only(['name', 'email', 'phone', 'group_id', 'barcode']));

        Group::clearManagerUser($staff->id);
        switch ((string) $request->input('role')) {
            case '1':
                $staff->group->deputy_manager = $staff->id;
                $staff->group->save();
                break;
            case '2':
                $staff->group->manager = $staff->id;
                $staff->group->save();
                break;
        }

        return $this->returnSuccess('Update success.', $staff);
    }

    /**
     * @param Staff $staff
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return $this->returnSuccess('destroy success.');
    }
}
