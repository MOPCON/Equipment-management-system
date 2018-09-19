<?php
namespace App\Services;

use App\TelegramMessage;
use Illuminate\Support\Facades\Log;

class TelegramMessageService
{
    private $telegramBotService;

    public function __construct(TelegramBotService $telegramBotService)
    {
        $this->telegramBotService = $telegramBotService;
    }

    public function send(TelegramMessage $telegramMessage)
    {
        if (!$telegramMessage->channel()) {
            $telegramMessage->changeStatusToFail();

            return;
        }

        $chatID = $telegramMessage->channel->code;
        $message = $this->generateMessage($telegramMessage);

        $result = $this->telegramBotService->send($chatID, $message);
        if ($result) {
            $telegramMessage->changeStatusToSend();
            Log::info("[TelegramMessageService] Send message success {$telegramMessage->id}");
        } else {
            $telegramMessage->changeStatusToFail();
            Log::error("[TelegramMessageService] Send message error {$telegramMessage->id}");
        }
    }

    private function generateMessage(TelegramMessage $telegramMessage)
    {
        if ($telegramMessage->display_name) {
            return "{$telegramMessage->display_name} 廣播：{$telegramMessage->content}";
        }

        return "{$telegramMessage->content}";
    }
}