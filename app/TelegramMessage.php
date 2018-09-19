<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $table = "telegram_messages";
    protected $fillable = ["user_id", "sending_time", "channel_id", "display_name", "content"];

    const WAIT_SEND_STATUS = 0;
    const SEND_STATUS = 1;
    const FAIL_STATUS = 2;

    public function channel()
    {
        return $this->hasOne('App\TelegramChannel');
    }

    public function isSend()
    {
        return $this->status === $this::SEND_STATUS;
    }

    public function changeStatusToFail()
    {
        $this->update(['status' => $this::FAIL_STATUS]);
    }

    public function changeStatusToSend()
    {
        $this->update(['status' => $this::SEND_STATUS]);
    }
}
