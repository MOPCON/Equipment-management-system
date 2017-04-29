<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Services\ApiService;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Services\ApiService
     */
    public function index(Request $request)
    {
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('$order_method', 'desc');
        $limit = $request->input('limit', 15);
        $group = Group::orderBy($order_field, $order_method)
            ->paginate($limit);

        return ApiService::returnApiResponse('Success.', $group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupRequest $request
     * @return \App\Services\ApiService
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->all());

        return ApiService::returnApiResponse('Store Success.', $group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group $group
     * @return \App\Services\ApiService
     */
    public function show(Group $group)
    {
        return ApiService::returnApiResponse('Show Success.', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $request
     * @param Group        $group
     * @return \App\Services\ApiService
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->all());

        return ApiService::returnApiResponse('Update Success.', $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group $group
     * @return \App\Services\ApiService
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return ApiService::returnApiResponse('Destroy Success.');
    }

    public function assignManager(Group $group, $staff_id)
    {
        $group->manager = $staff_id;
        $group->save();

        return ApiService::returnApiResponse('Assign manager Success.', $group);
    }

    public function assignDeputyManager(Group $group, $staff_id)
    {
        $group->deputy_manager = $staff_id;
        $group->save();

        return ApiService::returnApiResponse('Assign deputy manager Success.', $group);
    }
}
