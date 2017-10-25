<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Staff;

class Group extends Model
{
    public $timestamps = false;
    protected $table = 'groups';
    protected $fillable = [
        'name', 'manager', 'deputy_manager',
    ];
    protected $appends = ['manager_name', 'deputy_manager_name'];

    public function getManagerNameAttribute()
    {
        $staff = Staff::find($this->manager);

        return $staff ? $staff->name : '';
    }

    public function getDeputyManagerNameAttribute()
    {
        $staff = Staff::find($this->deputy_manager);

        return $staff ? $staff->name : '';
    }

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
