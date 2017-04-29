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

    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }
}
