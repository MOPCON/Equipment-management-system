<?php

namespace App\Http\Controllers;

trait ApiTrait
{
    /**
     * @param string $message
     * @param array  $data
     * @param bool   $success
     * @param int    $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnApiResponse($message = '', $data = [], $success = true, $code = 200)
    {
        return response()->json([
            'success'  => $success,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }

    /**
     * Return 200
     * @param string $message
     * @param array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnSuccess($message = 'Success', $data = [])
    {
        return $this->returnApiResponse($message, $data);
    }

    /**
     * Return 400
     * @param string $message
     * @param array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function return400Response($message = 'Bad request', $data = [])
    {
        return $this->returnApiResponse($message, $data, false, 400);
    }

    /**
     * Return 404
     * @param string $message
     * @param array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function return404Response($message = 'Not found', $data = [])
    {
        return $this->returnApiResponse($message, $data, false, 404);
    }

}