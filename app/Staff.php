<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public $timestamps = false;
    protected $table = 'staffs';
    protected $fillable = [
        'name', 'email', 'phone', 'group_id', 'barcode',
    ];
}
