<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class WhoAmIConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     * @throws \BotMan\BotMan\Exceptions\Base\BotManException
     */
    public function run()
    {
        $formId = $this->bot->getUser()->getId();
        $this->bot->reply("Your id is: $formId");
    }
}
