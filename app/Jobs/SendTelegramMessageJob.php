<?php

namespace App\Jobs;

use App\BotMessage;
use Illuminate\Bus\Queueable;
use App\Services\BotManService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTelegramMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $telegramMessage;

    /**
     * Create a new job instance.
     *
     * @param BotMessage $telegramMessage
     */
    public function __construct(BotMessage $telegramMessage)
    {
        $this->telegramMessage = $telegramMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        app()->make(BotManService::class)->send($this->telegramMessage);
    }
}
