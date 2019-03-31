<?php

namespace App\Services;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\Log;

class TelegramBotService
{
    private $telegram;

    public function __construct()
    {
        $this->telegram = new Telegram(env('PHP_TELEGRAM_BOT_API_KEY'), env('PHP_TELEGRAM_BOT_NAME'));
    }

    public function send($chat_id, $message)
    {
        $data = [
            'chat_id' => $chat_id,
            'text'    => $message,
        ];

        $result = Request::sendMessage($data);
        if (! $result->isOk()) {
            Log::error("[TelegramBotService] Send message error {$result->getDescription()}");
        }

        return $result->isOk();
    }
}
