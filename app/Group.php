<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    protected $table = 'groups';
    protected $fillable = [
        'name', 'manager', 'deputy_manager',
    ];

    /**
     * 取得群組ID陣列
     * @return array
     */
    public static function getGroupIdArray()
    {
        $array = [];
        for ($i = 1; $i <= Group::count(); $i++) {
            $array[] = $i;
        }

        return $array;
    }

    public function users()
    {
        return $this->hasMany('App\Staff');
    }

    public static function clearManagerUser($staff_id)
    {
        $group = Group::where('manager', $staff_id)->first();
        if ($group) {
            $group->manager = 0;
            $group->save();
        }
        $group = Group::where('deputy_manager', $staff_id)->first();
        if ($group) {
            $group->deputy_manager = 0;
            $group->save();
        }
    }
}
