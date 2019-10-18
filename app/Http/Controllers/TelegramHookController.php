<?php

namespace App\Http\Controllers;

class TelegramHookController extends Controller
{
    public function __construct()
    {
        require base_path('routes/botman.php');
    }

    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }
}
