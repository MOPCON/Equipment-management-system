<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $timestamps = false;
    protected $table = 'equipments';
    protected $fillable = [
        'name', 'source', 'memo', 'amount', 'hasBarcode', 'prefix',
    ];

    public function barcode()
    {
        return $this->hasMany('App\EquipmentBarcode');
    }

    public function loans()
    {
        return $this->hasMany('App\Loan');
    }

    public function last()
    {
        return $this->amount - $this->loan;
    }

    public function setBarcode()
    {
        EquipmentBarcode::where('equipment_id', $this->id)->delete();
        if ($this->hasBarcode) {
            for ($i = 0; $i < $this->amount; $i++) {
                EquipmentBarcode::create([
                    'barcode'      => $this->prefix . str_pad(($i), 3, '0', STR_PAD_LEFT),
                    'equipment_id' => $this->id,
                ]);
            }
        }
    }
}
