<?php

namespace App\Http\Controllers;

class TelegramHookController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }
}
