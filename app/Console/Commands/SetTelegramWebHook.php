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
    protected $signature = 'ems:set-telegram-hook {--d|delete : 刪除所有 WebHook} {--output}';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            $url = 'https://api.telegram.org/bot'
                . config('botman.telegram.token')
                . '/setWebhook';

            $remove = $this->option('delete', null);

            if (!$remove) {
                $url .= '?url=' . action('TelegramHookController@handle');
            }

            $this->info('Using ' . $url);

            $this->info('Pinging Telegram...');

            $client = new \GuzzleHttp\Client();
            $response = @$client->request('GET', $url);
            $result = json_decode($response->getBody());
            if ($result->ok == true && $result->result == true) {
                $this->info(
                    $remove
                    ? 'Your bot Telegram\'s webhook has been removed!'
                    : 'Your bot is now set up with Telegram\'s webhook!'
                );
            }

            if ($this->option('output')) {
                dump($result);
            }
        } catch (\Exception $e) {
            $this->error('發生不明錯誤');
            $this->error($e->getMessage());
            Log::error($e->getMessage() . $e->getTraceAsString());
        }
    }
}
