<?php

namespace App\Http\Controllers;

use App\User;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramHookController extends Controller
{
    public function handle(PhpTelegramBotContract $telegramBot)
    {
        $adminIds = User::whereNotNull('telegram_id')->pluck('telegram_id');
        $telegramBot->enableAdmins($adminIds);
        $telegramBot->handle();
    }
}
