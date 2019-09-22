<?php

namespace App\Services;

use App\BotMessage;
use Illuminate\Support\Facades\Log;
use BotMan\Drivers\Telegram\TelegramDriver;
use mysql_xdevapi\Exception;

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
            if (!$telegramMessage->channels->count()) {
                $telegramMessage->changeStatusToFail();

                return;
            }
            $telegramMessage->as_time = date('Y-m-d H:i:s');
            $message = $telegramMessage->full_message;

            foreach ($telegramMessage->channels as $channel) {
                $chatID = $channel->code;
                $result = $this->botman->say($message, $chatID, TelegramDriver::class);

                if (!$result->isOk()) {
                    throw new \Exception('Request error: ' . $result->getContent());
                }
                Log::info("[TelegramMessageService] Send message to {$channel->name}({$channel->code})");
            }

            $telegramMessage->changeStatusToSend();
            Log::info("[TelegramMessageService] Send message success {$telegramMessage->id}");
        } catch (\Exception $e) {
            $telegramMessage->changeStatusToFail();
            Log::error("[TelegramMessageService] Send message error {$telegramMessage->id} 
            \n {$e->getMessage()} \n{$e->getTraceAsString()}");
        }
    }
}
