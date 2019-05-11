<?php

namespace App\Conversations\Commands;

use App\TelegramChannel;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SaveIdConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     * @throws \BotMan\BotMan\Exceptions\Base\BotManException
     */
    public function run()
    {
        $code = $this->bot->getMessage()->getRecipient();
        $name = $this->bot->getMessage()->getPayload()['chat']['title']
            ?? $this->bot->getUser()->getUsername() ?? '(未命名)';

        TelegramChannel::updateOrCreate([
            'code' => $code,
        ], [
            'name' => $name,
        ]);

        $this->bot->reply("Done!");
    }
}
