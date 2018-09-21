<?php

namespace App\Http\Controllers;

use App\User;
use Longman\TelegramBot\Request;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramHookController extends Controller
{
    public function handle(PhpTelegramBotContract $telegramBot)
    {
        $request = json_decode(Request::getInput(), true);
        $isBotCommand = in_array("bot_command", array_pluck($request['message']['entities'], 'type'));
        if ($isBotCommand) {
            $adminIds = array_map('intval', User::whereNotNull('telegram_id')->pluck('telegram_id')->toArray());
            $telegramBot->enableAdmins($adminIds);
            $telegramBot->handle();
            info("[TelegramHook] Got Command: " . Request::getInput());
        }
    }
}
