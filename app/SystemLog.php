<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_logs';
    protected $fillable = [
        'user_id',
        'type_id',
        'content',
        'ip',
        'device',
        'browser',
    ];
    protected $appends = ['user_name', 'type_name'];

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getTypeNameAttribute()
    {
        return $this->type->name;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function type()
    {
        return $this->belongsTo('App\SystemLogType');
    }
}
