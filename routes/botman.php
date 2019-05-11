<?php

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $bot->reply('Hello!');
});
