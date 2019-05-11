<?php

namespace App\Http\Controllers;

use App\User;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\Cache;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramHookController extends Controller
{
    private $expiresMinutes = 10;

    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }

    private function getAdminIds()
    {
        if (Cache::has('adminIds')) {
            $adminIds = Cache::get('adminIds');
        } else {
            info('[TelegramHook] renew admin ids.');
            $adminIds = array_map('intval', User::whereNotNull('telegram_id')->pluck('telegram_id')->toArray());
            Cache::put('adminIds', $adminIds, $this->expiresMinutes);
        }

        return $adminIds;
    }
}
