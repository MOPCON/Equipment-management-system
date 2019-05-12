<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $table = 'telegram_messages';
    protected $fillable = ['user_id', 'es_time', 'channel_id', 'display_name', 'content', 'status'];
    protected $appends = ['full_message'];

    const WAIT_SEND_STATUS = 0;
    const SENDING = 3;
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

    public function getFullMessageAttribute()
    {
        if ($this->display_name !== null) {
            return "{$this->display_name} 說：\n" . $this->content;
        }

        return $this->content;
    }

    public function scopeWaitSend($query)
    {
        return $query->where('status', $this::WAIT_SEND_STATUS);
    }

    public function isSend()
    {
        return $this->status === $this::SEND_STATUS;
    }

    public function changeStatusToWaitSend()
    {
        $this->status = $this::WAIT_SEND_STATUS;
        $this->save();
    }

    public function changeStatusToSending()
    {
        $this->status = $this::SENDING;
        $this->save();
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
