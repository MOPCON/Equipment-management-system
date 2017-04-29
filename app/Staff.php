<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gravatar;

class Staff extends Model
{
    public $timestamps = false;
    protected $table = 'staffs';
    protected $fillable = [
        'name', 'email', 'phone', 'group_id', 'barcode',
    ];
    protected $appends = ['gravatar', 'group_name', 'role'];

    public function getGravatarAttribute()
    {
        return Gravatar::get($this->email);
    }

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

    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
