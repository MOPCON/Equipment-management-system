<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Services\ApiService;

class StaffController extends Controller
{
    /**
     * @param $request
     * @return \App\Services\ApiService
     */
    public function index(Request $request)
    {
        $group_id = $request->input('group_id', Group::getGroupIdArray());
        $search = $request->input('search', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 15);
        $staff = Staff::whereIn('group_id', $group_id)
            ->orWhere(function($query) use ($search) {
                $query->orWhere('name', '%' . $search . '%')
                    ->orWhere('email', '%' . $search . '%')
                    ->orWhere('phone', '%' . $search . '%');
            })
            ->orderBy($order_field, $order_method)
            ->paginate($limit);

        return ApiService::returnApiResponse('Success.', $staff);
    }

    /**
     * @param StaffRequest $request
     * @return \App\Services\ApiService
     */
    public function store(StaffRequest $request)
    {
        $staff = Staff::create($request->all());
        return ApiService::returnApiResponse('Store success.', $staff);
    }

    /**
     * @param Staff $staff
     * @return \App\Services\ApiService
     */
    public function show(Staff $staff)
    {
        return ApiService::returnApiResponse('Show success.', $staff);
    }

    /**
     * @param StaffRequest $request
     * @param Staff        $staff
     * @return \App\Services\ApiService
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $staff->update($request->all());
        return ApiService::returnApiResponse('Update success.', $staff);
    }

    /**
     * @param Staff $staff
     * @return \App\Services\ApiService
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return ApiService::returnApiResponse('destroy success.', []);
    }
}
