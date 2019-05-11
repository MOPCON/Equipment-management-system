<?php

namespace App\Http\Middleware\Botman;

use App\User;
use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Cache;
use BotMan\BotMan\Interfaces\Middleware\Heard;
use BotMan\BotMan\Interfaces\Middleware\Sending;
use BotMan\BotMan\Interfaces\Middleware\Captured;
use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class AdminMiddleware implements Received, Captured, Matching, Heard, Sending
{
    private $adminIdListCacheExpiresMinutes = 10;

    /**
     * Handle a captured message.
     *
     * @param \BotMan\BotMan\Messages\Incoming\IncomingMessage $message
     * @param BotMan                                           $bot
     * @param                                                  $next
     *
     * @return mixed
     */
    public function captured(IncomingMessage $message, $next, BotMan $bot)
    {
        return $next($message);
    }

    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param BotMan          $bot
     * @param                 $next
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        return $next($message);
    }

    /**
     * @param \BotMan\BotMan\Messages\Incoming\IncomingMessage $message
     * @param string                                           $pattern
     * @param bool                                             $regexMatched Indicator if the regular expression was
     *                                                                       matched too
     * @return bool
     */
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        $isAdmin = in_array($message->getSender(), $this->getAdminIds());

        if (! $isAdmin && $regexMatched) {
            $userTag = $message->getPayload()['from']['username'] !== '' ?
                '@' . $message->getPayload()['from']['username'] : '';
            $botman = app('botman');
            $botman->say("$userTag 你不能使用這個命令呦！ (*´･д･)", $message->getRecipient());
        }

        return $regexMatched && $isAdmin;
    }

    /**
     * Handle a message that was successfully heard, but not processed yet.
     *
     * @param \BotMan\BotMan\Messages\Incoming\IncomingMessage $message
     * @param BotMan                                           $bot
     * @param                                                  $next
     *
     * @return mixed
     */
    public function heard(IncomingMessage $message, $next, BotMan $bot)
    {
        return $next($message);
    }

    /**
     * Handle an outgoing message payload before/after it
     * hits the message service.
     *
     * @param mixed  $payload
     * @param BotMan $bot
     * @param        $next
     *
     * @return mixed
     */
    public function sending($payload, $next, BotMan $bot)
    {
        return $next($payload);
    }

    private function getAdminIds()
    {
        if (Cache::has('adminIds')) {
            $adminIds = Cache::get('adminIds');
        } else {
            $adminIds = array_map('intval', User::whereNotNull('telegram_id')->pluck('telegram_id')->toArray());
            Cache::put('adminIds', $adminIds, $this->adminIdListCacheExpiresMinutes);
        }

        return $adminIds;
    }
}
