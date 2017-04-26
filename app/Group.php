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
}
