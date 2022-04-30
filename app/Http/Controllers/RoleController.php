<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Role;

class RoleController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    /**
     * RoleController constructor.
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
    public function index()
    {
        $roles = Role::all();

        return $this->returnSuccess('Success', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->input('permissions'));

        return $this->returnSuccess('Store Success', $role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);

        return $this->returnSuccess('Success', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only('name'));
        $role->syncPermissions($request->input('permissions'));

        return $this->returnSuccess('Update Success', $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return $this->returnSuccess('Success', $role);
    }
}
