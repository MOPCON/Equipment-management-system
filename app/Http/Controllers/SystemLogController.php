<?php

namespace App\Http\Controllers;

use App\User;
use App\SystemLog;
use Illuminate\Http\Request;
use App\Http\Requests\SystemLogRequest;

class SystemLogController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type_id = $request->input('type_id', null);
        $search = json_decode($request->input('search', '{}'), true);
        $order_field = $request->input('sort', 'system_logs.created_at');
        $order_method = $request->input('order', 'desc');
        $limit = $request->input('limit', 25);

        $user_id = [];
        if (isset($search['username']) && trim($search['username']) !== '') {
            $user_id = User::where('name', 'LIKE', '%' . $search['username'] . '%')
                ->pluck('id');
        }

        $query = SystemLog::where(function ($query) use ($search, $user_id) {
            if (isset($search['content']) && trim($search['content']) !== '') {
                $query->where('content', 'LIKE', '%' . $search['content'] . '%');
            }
            if (!empty($user_id)) {
                $query->whereIn('user_id', $user_id);
            }
        });

        if (!is_null($type_id)) {
            $query->where('type_id', $type_id);
        }

        $system_log = $query->orderBy($order_field, $order_method)
            ->paginate($limit);

        return $this->returnSuccess('Success.', $system_log);
    }
}
