<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';
    protected $fillable = [
        'staff_id', 'equipment_id', 'amount', 'barcode',
    ];
    protected $appends = ['staff_name', 'equipment_name'];

    public function getStaffNameAttribute()
    {
        return $this->staff->name;
    }

    public function getEquipmentNameAttribute()
    {
        return $this->equipment->name;
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }

    public function equipmentBarcode()
    {
        return $this->belongsTo('App\EquipmentBarcode', 'barcode', 'barcode');
    }

    public function last()
    {
        return $this->amount - $this->return_back;
    }
}
