<?php
namespace App\Services;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class TelegramBotService
{
    private $telegram;

    public function __construct()
    {
        $this->telegram = new Telegram(env("TELEGRAM_API_KEY"), env("TELEGRAM_BOT_NAME"));
    }

    public function send($chat_id, $message)
    {
        $data = [
            'chat_id' => $chat_id,
            'text'    => $message,
        ];

        $result = Request::sendMessage($data);

        return $result->isOk();
    }
}