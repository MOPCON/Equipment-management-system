<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Services\ApiService;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('$order_method', 'desc');
        $limit = $request->input('limit', 15);
        $user = User::orderBy($order_field, $order_method)
            ->paginate($limit);

        return ApiService::returnApiResponse('Success.', $user);
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());

        return ApiService::returnApiResponse('Store Success.', $user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return ApiService::returnApiResponse('Show Success.', $user);
    }

    /**
     * @param UserRequest $request
     * @param User        $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return ApiService::returnApiResponse('Show Success.', $user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ApiService::returnApiResponse('Destroy Success.', $user);
    }

    public function changePassword(Request $request, User $user)
    {
        if (!$request->has('password')) {
            return ApiService::returnApiResponse('Missing password.', [], false, 400);
        }
        $user->password = bcrypt($request->password);
        return ApiService::returnApiResponse('Change password Success.');
    }
}
