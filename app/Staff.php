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
    protected $appends = ['gravatar', 'group_name'];

    public function getGravatarAttribute()
    {
        return Gravatar::get($this->email);
    }

    public function getGroupNameAttribute()
    {
        return $this->group->name;
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
