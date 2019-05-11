<?php

namespace App\Http\Middleware\Botman;

use App\User;
use Illuminate\Support\Facades\Cache;
use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

/**
 * 僅允許 Admin 通過
 * Class AdminMiddleware
 * @package App\Http\Middleware\Botman
 */
class AdminMiddleware implements Matching
{
    private $adminIdListCacheExpiresMinutes = 10;

    /**
     * @param IncomingMessage $message
     * @param string          $pattern
     * @param bool            $regexMatched Indicator if the regular expression was matched too.
     * @return bool
     */
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        $isAdmin = in_array($message->getSender(), $this->getAdminIds());

        if (!$isAdmin && $regexMatched) {
            $userTag = $message->getPayload()['from']['username'] !== '' ?
                '@' . $message->getPayload()['from']['username'] : '';
            $botman = app('botman');
            $botman->say("$userTag 你不能使用這個命令呦！ (*´･д･)", $message->getRecipient());
        }

        return $regexMatched && $isAdmin;
    }

    /**
     * 取得目前管理員的 Telegram Id.
     * @return array
     */
    private function getAdminIds()
    {
        if (Cache::has('adminIds')) {
            return Cache::get('adminIds');
        }

        $adminIds = array_map('intval', User::whereNotNull('telegram_id')->pluck('telegram_id')->toArray());
        Cache::put('adminIds', $adminIds, $this->adminIdListCacheExpiresMinutes);

        return $adminIds;
    }
}
