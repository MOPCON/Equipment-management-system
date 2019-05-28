<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\SystemLogType;
use App\Services\SystemLogService;

class UserController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    private $SystemLog;
    private $SystemLogTypeId;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->checkPermissionApiResource();
        $this->checkPermission('User:Write', 'changePassword');
        $this->SystemLog = new SystemLogService();
        $this->SystemLogTypeId = SystemLogType::where('name', '使用者管理')->first()->id;
    }

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

        $content = '新增 -> ' . $user->name . '(id:' . $user->id . ')';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

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
            'telegram_id' => $request->telegram_id,
        ]);

        $content = '編輯 -> ' . $user->name . '(id:' . $user->id . ')';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

        return $this->returnSuccess('Show Success.', $user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        $content = '刪除使用者 -> ' . $user->name . '(id:' . $user->id . ')';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

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

        $content = '修改密碼 -> ' . $user->name . '(id:' . $user->id . ')';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

        return $this->returnSuccess('Change password Success.', $user);
    }
}
