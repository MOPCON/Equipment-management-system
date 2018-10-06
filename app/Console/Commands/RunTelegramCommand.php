<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class RunTelegramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ems:telegram-run {cmd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run telegram command';

    private $telegramBot;

    /**
     * Create a new command instance.
     *
     * @param PhpTelegramBotContract $telegramBot
     */
    public function __construct(PhpTelegramBotContract $telegramBot)
    {
        parent::__construct();
        $this->telegramBot = $telegramBot;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function handle()
    {
        $this->telegramBot->runCommands([$this->argument('cmd')]);
    }
}
