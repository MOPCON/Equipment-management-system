<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use App\TelegramChannel;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class WhoAmICommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'whoAmI';

    /**
     * @var string
     */
    protected $description = 'Print self id';

    /**
     * @var string
     */
    protected $usage = '/whoAmI';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $need_mysql = false;

    protected $private_only = true;

    /**
     * Execute command
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        /** 驗證身份 */
        $message = $this->getMessage();
        $chat = $message->getChat();

        $data = [
            'chat_id' => $chat->getId(),
            'text'    => 'You are ' . $message->getFrom()->getId()
        ];

        return Request::sendMessage($data);
    }
}