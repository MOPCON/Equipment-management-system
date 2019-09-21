<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BotChannel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code'];
}
