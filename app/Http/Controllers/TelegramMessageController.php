<?php

namespace App\Http\Controllers;

use App\BotMessage;
use Illuminate\Http\Request;
use App\Jobs\SendTelegramMessageJob;
use App\Http\Requests\TelegramMessageRequest;

class TelegramMessageController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    /**
     * TelegramMessageController constructor.
     */
    public function __construct()
    {
        $this->checkPermissionApiResource();
        $this->checkPermission('TelegramMessage:Write', 'sendNow');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $channel_id = $request->input('channel_id', 0);
        $search = $request->input('search', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 25);

        $telegramMessages = BotMessage::where(function ($query) use ($search, $channel_id) {
            if ($channel_id) {
                $query->where('channel_id', $channel_id);
            }

            if ($search) {
                $query->where('display_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('content', 'LIKE', '%' . $search . '%');
            }
        })
            ->with(['channels', 'user'])
            ->orderBy($order_field, $order_method)
            ->paginate($limit);

        return $this->returnSuccess('Success.', $telegramMessages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TelegramMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TelegramMessageRequest $request)
    {
        $data = $request->only(['es_time', 'display_name', 'content']);
        $data['user_id'] = auth()->id();
        $message = BotMessage::create($data);
        $message->channels()->attach($request->input('channel_ids'));

        if ($request->input('now_send')) {
            $data['status'] = BotMessage::SENDING;
            SendTelegramMessageJob::dispatch($message);
        }

        return $this->returnSuccess('Success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BotMessage $telegramMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BotMessage $telegramMessage)
    {
        $telegramMessage->channels;
        $telegramMessage->user;

        return $this->returnSuccess('Success', $telegramMessage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TelegramMessageRequest $request
     * @param  \App\BotMessage       $telegramMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TelegramMessageRequest $request, BotMessage $telegramMessage)
    {
        if ($telegramMessage->isSend()) {
            return $this->return400Response('訊息已發送，無法變更。');
        }
        $telegramMessage->update($request->only(['es_time', 'display_name', 'content']));
        $telegramMessage->channels()->sync($request->input('channel_ids'));

        return $this->returnSuccess(
            'Success',
            $telegramMessage
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BotMessage $telegramMessage
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(BotMessage $telegramMessage)
    {
        if ($telegramMessage->isSend()) {
            return $this->return400Response('訊息已發送，無法刪除。');
        }

        return $this->returnSuccess('Success', $telegramMessage->delete());
    }

    public function sendNow(BotMessage $telegramMessage)
    {
        if ($telegramMessage->isSend()) {
            return $this->return400Response('訊息已發送，無法再發送。');
        }

        if ($telegramMessage->es_time !== null) {
            $telegramMessage->changeStatusToWaitSend();
            return $this->returnSuccess('已重啟排程');
        }

        $telegramMessage->changeStatusToSending();
        SendTelegramMessageJob::dispatch($telegramMessage);

        return $this->returnSuccess('已發送');
    }
}
