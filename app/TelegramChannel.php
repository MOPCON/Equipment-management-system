<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramChannel extends Model
{
    protected $table = 'telegram_channels';
    protected $fillable = ['name', 'code'];
}
