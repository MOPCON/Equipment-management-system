<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLogType extends Model
{
    protected $table = 'system_log_type';
    protected $fillable = ['name'];

    public function system_log()
    {
        return $this->hasMany('App\SystemLog');
    }
}
