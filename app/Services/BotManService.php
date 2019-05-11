<?php

namespace App\Services;

use App\TelegramMessage;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\Facades\Log;

class BotManService
{
    private $botman;

    public function __construct()
    {
        $this->botman = app('botman');
    }

    /**
     * 發送訊息至 Telegram
     * @param TelegramMessage $telegramMessage
     */
    public function send(TelegramMessage $telegramMessage): void
    {
        try {
            if (!$telegramMessage->channel) {
                $telegramMessage->changeStatusToFail();
                return;
            }

            $chatID = $telegramMessage->channel->code;
            $message = $telegramMessage->content;

            $this->botman->say($message, $chatID, TelegramDriver::class);
            $telegramMessage->changeStatusToSend();
            Log::info("[TelegramMessageService] Send message success {$telegramMessage->id}");
        } catch (\Exception $e) {
            $telegramMessage->changeStatusToFail();
            Log::error("[TelegramMessageService] Send message error {$telegramMessage->id} 
            \n {$e->getMessage()} \n{$e->getTraceAsString()}");
        }
    }
}