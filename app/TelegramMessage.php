<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $table = 'telegram_messages';
    protected $fillable = ['user_id', 'sending_time', 'channel_id', 'display_name', 'content', 'status'];

    const WAIT_SEND_STATUS = 0;
    const NOW_SEND = 3;
    const SEND_STATUS = 1;
    const FAIL_STATUS = 2;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function channel()
    {
        return $this->hasOne('App\TelegramChannel', 'id', 'channel_id');
    }

    public function scopeWaitSend($query)
    {
        return $query->where('status', $this::WAIT_SEND_STATUS);
    }

    public function isSend()
    {
        return $this->status === $this::SEND_STATUS;
    }

    public function changeStatusToFail()
    {
        $this->status = $this::FAIL_STATUS;
        $this->save();
    }

    public function changeStatusToSend()
    {
        $this->status = $this::SEND_STATUS;
        $this->save();
    }
}
