<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SetTelegramWebHook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ems:set-telegram-hook {--d|delete : 刪除所有 WebHook}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '設定 Telegram 的 Hook';

    private $telegramBot;

    /**
     * Create a new command instance.
     *
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
        try {
            if ($this->option('delete')) {
            } else {
                $hookUrl = action('TelegramHookController@handle');
            }


        } catch (\Exception $e) {
            $this->error('發生不明錯誤');
            Log::error($e->getMessage() . $e->getTraceAsString());
        }
    }
}
