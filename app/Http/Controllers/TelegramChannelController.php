<?php

namespace App\Http\Controllers;

use App\TelegramChannel;
use App\Http\Requests\TelegramChannelRequest;
use App\SystemLogType;
use App\Services\SystemLogService;

class TelegramChannelController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    private $SystemLog;
    private $SystemLogTypeId;

    /**
     * TelegramChannelController constructor.
     */
    public function __construct()
    {
        $this->checkPermissionApiResource();
        $this->SystemLog = new SystemLogService();
        $this->SystemLogTypeId = SystemLogType::where('name', '頻道管理')->first()->id;
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
        $telegramChannel = TelegramChannel::create($request->only(['name', 'code']));

        $content = '新增 -> ' . $telegramChannel->name . ' ( id:' . $telegramChannel->id . ' )';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

        return $this->returnSuccess('Success', $telegramChannel);
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
        $telegramChannel->update($request->only(['name', 'code']));

        $content = '編輯 -> ' . $telegramChannel->name . ' ( id:' . $telegramChannel->id . ' )';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

        return $this->returnSuccess('Success', $telegramChannel);
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
        $telegramChannel->delete();

        $content = '刪除 -> ' . $telegramChannel->name . ' ( id:' . $telegramChannel->id . ' )';
        $this->SystemLog->write($content, $this->SystemLogTypeId);

        return $this->returnSuccess('Success', $telegramChannel);
    }
}
