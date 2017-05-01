<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentBarcode extends Model
{
    public $timestamps = false;
    protected $table = 'equipment_barcodes';
    protected $fillable = [
        'barcode', 'equipment_id',
    ];
    protected $appends = ['equipment_name'];

    public function getEquipmentNameAttribute()
    {
        return $this->equipment->name;
    }

    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }

    public function loan()
    {
        return $this->hasOne('App\Loan');
    }
}
