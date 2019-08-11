<?php

namespace App\Http\Middleware\Botman;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Heard;
use BotMan\BotMan\Interfaces\Middleware\Sending;
use BotMan\BotMan\Interfaces\Middleware\Captured;
use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

/**
 * 僅允許個人頻道通過
 * Class PrivateChatMiddleware
 * @package App\Http\Middleware\Botman
 */
class PrivateChatMiddleware implements Matching
{
    /**
     * @param \BotMan\BotMan\Messages\Incoming\IncomingMessage $message
     * @param string $pattern
     * @param bool $regexMatched Indicator if the regular expression was matched too
     * @return bool
     */
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        return $regexMatched && $message->getPayload()['chat']['type'] === 'private';
    }
}
