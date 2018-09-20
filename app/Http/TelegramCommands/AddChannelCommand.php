<?php
namespace App\TelegramCommands;

use App\TelegramChannel;
use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\Request;

class AddChannelCommand extends AdminCommand
{
    /**
     * @var string
     */
    protected $name = 'Channel Add';

    /**
     * @var string
     */
    protected $description = 'Add channel id to db';

    /**
     * @var string
     */
    protected $usage = '/start-channel';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $need_mysql = false;

    /**
     * Execute command
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat = $message->getChat();
        TelegramChannel::create([
            'name' => $chat->getTitle(),
            'code' => $chat->getId()
        ]);

        $data = [
            'chat_id' => $chat->getId(),
            'text'    => 'Done!'
        ];

        return Request::sendMessage($data);
    }
}