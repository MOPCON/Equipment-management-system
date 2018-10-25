<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Request;

trait CommandTrait
{
    protected function getUnAuthMessage($chat, $message)
    {
        return Request::sendMessage([
            'chat_id' => $chat->getId(),
            'text' => '@' . $message->getFrom()->getUsername() . ' (ㆆᴗㆆ)'
        ]);
    }
}
