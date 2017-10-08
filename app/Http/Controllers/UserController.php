<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Http\Controllers\ApiTrait;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use ApiTrait;

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('order_method', 'desc');
        $limit = $request->input('limit', 15);
        $user = User::orderBy($order_field, $order_method)
            ->paginate($limit);

        return $this->returnSuccess('Success.', $user);
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());

        return $this->returnSuccess('Store Success.', $user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $this->returnSuccess('Show Success.', $user);
    }

    /**
     * @param UserRequest $request
     * @param User        $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return $this->returnSuccess('Show Success.', $user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->returnSuccess('Destroy Success.', $user);
    }

    /**
     * @param UserRequest $request
     * @param User        $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(UserRequest $request, User $user)
    {
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->returnSuccess('Change password Success.', $user);
    }
}
