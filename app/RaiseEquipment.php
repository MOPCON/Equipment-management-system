<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaiseEquipment extends Model
{
    protected $table = 'raise_equipments';
    protected $fillable = [
        'name', 'staff_id', 'barcode', 'status',
    ];
    protected $appends = ['staff_name', 'status_name'];

    private $statusName = ['未收到', '未出借', '出借中', '已歸還'];

    public function getStaffNameAttribute()
    {
        return $this->staff->name;
    }

    public function getStatusNameAttribute()
    {
        return $this->statusName[$this->status ?? 0];
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }
}
