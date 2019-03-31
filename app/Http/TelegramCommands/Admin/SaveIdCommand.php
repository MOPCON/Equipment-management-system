<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\TelegramChannel;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Commands\AdminCommand;

class SaveIdCommand extends AdminCommand
{
    use CommandTrait;

    /**
     * @var string
     */
    protected $name = 'saveId';

    /**
     * @var string
     */
    protected $description = 'Add channel id to db';

    /**
     * @var string
     */
    protected $usage = '/saveId';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $need_mysql = false;

    protected $private_only = false;

    /**
     * Execute command.
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        /** 驗證身份 */
        $message = $this->getMessage();
        $chat = $message->getChat();

        if (! in_array($message->getFrom()->getId(), $this->getTelegram()->getAdminList())) {
            return $this->getUnAuthMessage($chat, $message);
        }

        /* 執行區間 */
        TelegramChannel::updateOrCreate([
            'code' => $chat->getId(),
        ], [
            'name' => $chat->getTitle() ?? $chat->getUsername() ?? '(未命名)',
        ]);

        $data = [
            'chat_id' => $chat->getId(),
            'text'    => 'Done!',
        ];

        return Request::sendMessage($data);
    }
}
