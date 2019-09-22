<?php

namespace App\Http\Middleware\Botman;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class CommandClearMiddleware implements Received
{

    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable        $next
     * @param BotMan          $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        // 過濾掉 @xxxxxxx，讓 /save@puck_bot 變成 /save
        $message->setText(preg_replace('/@.*/', '', $message->getText()));

        return $next($message);
    }
}
