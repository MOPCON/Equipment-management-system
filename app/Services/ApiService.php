<?php

namespace App\Services;

class ApiService
{
    /**
     * @param string $message
     * @param array  $data
     * @param bool   $success
     * @param int    $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnApiResponse($message = '', $data = [], $success = true, $code = 200)
    {
        return response()->json([
            'success'  => $success,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }
}