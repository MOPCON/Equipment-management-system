<?php

namespace App\Http\Controllers;

use App\TelegramChannel;
use App\Http\Requests\TelegramChannelRequest;

class TelegramChannelController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    /**
     * TelegramChannelController constructor.
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
        return $this->returnSuccess('Success', TelegramChannel::all());
    }

    /**
     * @param TelegramChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TelegramChannelRequest $request)
    {
        return $this->returnSuccess('Success', TelegramChannel::create($request->only(['name', 'code'])));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TelegramChannel  $telegramChannel
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TelegramChannel $telegramChannel)
    {
        return $this->returnSuccess('Success', $telegramChannel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TelegramChannelRequest $request
     * @param  \App\TelegramChannel  $telegramChannel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TelegramChannelRequest $request, TelegramChannel $telegramChannel)
    {
        return $this->returnSuccess('Success', $telegramChannel->update($request->only(['name', 'code'])));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TelegramChannel $telegramChannel
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(TelegramChannel $telegramChannel)
    {
        return $this->returnSuccess('Success', $telegramChannel->delete());
    }
}
