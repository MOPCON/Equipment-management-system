<?php

namespace App\Http\Controllers;

use App\Group;
use App\Staff;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;

class GroupController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    /**
     * GroupController constructor.
     */
    public function __construct()
    {
        $this->checkPermissionApiResource();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 15);
        $group = Group::orderBy($order_field, $order_method)
            ->paginate($limit);

        foreach ($group as $value) {
            $value->number = Staff::where('group_id', $value->id)->count();
        }

        return $this->returnSuccess('Success.', $group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->all());

        return $this->returnSuccess('Store Success.', $group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Group $group)
    {
        return $this->returnSuccess('Show Success.', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $request
     * @param Group        $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->all());

        return $this->returnSuccess('Update Success.', $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group)
    {
        if (count($group->users) > 0) {
            return $this->return404Response('該組還有組員，不能刪除。');
        }
        $group->delete();

        return $this->returnSuccess('Destroy Success.');
    }
}
