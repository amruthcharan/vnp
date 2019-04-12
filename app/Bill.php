<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //protected $primaryKey = "VNPI8000";

    protected $fillable = ['date', 'discount', 'total', 'patient_id'];

    public function patient() {
        return $this->belongsTo('App\Patient');
    }

    public function billcomponents() {
        return $this->hasMany('App\BillComponents');
    }

}
