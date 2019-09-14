<?php

namespace App\Services;

use App\BotMessage;
use Illuminate\Support\Facades\Log;
use BotMan\Drivers\Telegram\TelegramDriver;

class BotManService
{
    private $botman;

    public function __construct()
    {
        $this->botman = app('botman');
    }

    /**
     * 發送訊息至 Telegram.
     * @param BotMessage $telegramMessage
     */
    public function send(BotMessage $telegramMessage): void
    {
        try {
            if (! $telegramMessage->channel) {
                $telegramMessage->changeStatusToFail();

                return;
            }

            $chatID = $telegramMessage->channel->code;
            $message = $telegramMessage->full_message;

            $this->botman->say($message, $chatID, TelegramDriver::class);
            $telegramMessage->as_time = date('Y-m-d H:i:s');
            $telegramMessage->changeStatusToSend();
            Log::info("[TelegramMessageService] Send message success {$telegramMessage->id}");
        } catch (\Exception $e) {
            $telegramMessage->changeStatusToFail();
            Log::error("[TelegramMessageService] Send message error {$telegramMessage->id} 
            \n {$e->getMessage()} \n{$e->getTraceAsString()}");
        }
    }
}
