<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $table = "telegram_messages";
    protected $fillable = ["user_id", "sending_time", "channel_id", "display_name", "content"];

    public function channel()
    {
        return $this->hasOne('App\TelegramChannel');
    }

    public function isSend()
    {
        return $this->is_send === 1;
    }
}
