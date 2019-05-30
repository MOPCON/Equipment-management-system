<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLogType extends Model
{
    protected $table = 'system_log_types';
    protected $fillable = ['name'];

    public function system_log()
    {
        return $this->hasMany('App\SystemLog');
    }

    /**
     * 取得群組ID陣列.
     * @return array
     */
    public static function getSystemLogTypeIdArray()
    {
        return SystemLogType::pluck('id');
    }
}
