<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentValidation extends Model
{
    protected $table = 'student_validation';
    protected $fillable = [
        'verify_year', 'is_verify', 'verify_user_id', 'order_id', 'register_no',
        'purchase_date', 'name', 'email', 'school_name', 'file_link', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'verify_user_id', 'id');
    }
}
