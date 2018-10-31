<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Request;

trait CommandTrait
{
    protected function getUnAuthMessage($chat, $message)
    {
        $userName = $message->getFrom()->getUsername() ? '@' . $message->getFrom()->getUsername() :
            $message->getFrom()->getFirstName() . $message->getFrom()->getLastName();

        return Request::sendMessage([
            'chat_id' => $chat->getId(),
            'text' => $userName . ' (ㆆᴗㆆ)'
        ]);
    }
}
