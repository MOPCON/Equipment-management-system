<?php

namespace App\Http\Controllers;

use App\SystemLogType;
use Illuminate\Http\Request;

class SystemLogTypeController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'asc');
        $systemLogType = SystemLogType::select('id', 'name')
            ->orderBy($order_field, $order_method)
            ->get();

        return $this->returnSuccess('Success.', $systemLogType);
    }
}
