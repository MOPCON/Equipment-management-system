<?php

namespace App\Console\Commands;

use App\TelegramMessage;
use Illuminate\Console\Command;
use App\Jobs\SendTelegramMessageJob;

class SendTelegramMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ems:send-telegram-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '發送 Telegram 訊息';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $messages = TelegramMessage::waitSend()->where('es_time', '<', date('Y-m-d H:i'))->get();

        /** @var TelegramMessage $message */
        foreach ($messages as $message) {
            $message->changeStatusToSending();
            SendTelegramMessageJob::dispatch($message);
        }
    }
}
