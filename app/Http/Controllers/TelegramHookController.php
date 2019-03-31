<?php

namespace App\Http\Controllers;

use App\User;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\Cache;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramHookController extends Controller
{
    private $expiresMinutes = 10;

    public function handle(PhpTelegramBotContract $telegramBot)
    {
        $request = json_decode(Request::getInput(), true);
        $isBotCommand = array_key_exists('message', $request) &&
            array_key_exists('entities', $request['message']) &&
            in_array('bot_command', array_pluck($request['message']['entities'], 'type'));

        if (! $isBotCommand) {
            return;
        }
        info('[TelegramHook] Got Command: ' . Request::getInput());
        $adminIds = $this->getAdminIds();
        $telegramBot->enableAdmins($adminIds);
        $telegramBot->handle();
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
