<?php

use App\Conversations\Commands\SaveIdConversation;
use App\Conversations\WhoAmIConversation;
use App\Http\Middleware\Botman\AdminMiddleware;
use App\Http\Middleware\Botman\PrivateChatMiddleware;
use BotMan\BotMan\BotMan;

/** @var BotMan $botman */
$botman = resolve('botman');


/** 私人頻道限定 */
$botman->group(['middleware' => new PrivateChatMiddleware()], function (BotMan $botman) {
    $botman->hears('/start', function (BotMan $bot) {
        $bot->reply('Hello!');
    });

    $botman->hears('/whoami', function (BotMan $bot) {
        $bot->startConversation(new WhoAmIConversation());
    });
});

/** 管理員限定 */
$botman->group(['middleware' => new AdminMiddleware()], function (BotMan $botman) {
    $botman->hears('/saveId', function (BotMan $bot) {
        $bot->startConversation(new SaveIdConversation());
    });
});

