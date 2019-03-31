<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public $timestamps = false;
    protected $table = 'staffs';
    protected $fillable = [
        'name', 'email', 'phone', 'group_id', 'barcode', 'duties',
    ];
    protected $appends = ['group_name', 'role', 'role_name'];

    protected $roleName = ['組員', '副組長', '組長'];

    public function getGroupNameAttribute()
    {
        return $this->group->name;
    }

    public function getRoleAttribute()
    {
        if ($this->group->manager == $this->id) {
            return 2;
        }

        if ($this->group->deputy_manager == $this->id) {
            return 1;
        }

        return 0;
    }

    public function getRoleNameAttribute()
    {
        return $this->roleName[$this->role];
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function loans()
    {
        return $this->hasMany('App\Loan');
    }

    public function setRole($role_id)
    {
        Group::clearManagerUser($this->id);

        switch ((string) $role_id) { // 0->組員, 1->副組長, 2->組長
            case '1':
                $this->group->deputy_manager = $this->id;
                $this->group->save();
                break;
            case '2':
                $this->group->manager = $this->id;
                $this->group->save();
                break;
        }
    }
}
