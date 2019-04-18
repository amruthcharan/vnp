<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //protected $primaryKey = "VNPI8000";

    protected $fillable = ['date', 'discount', 'nettotal', 'grandtotal', 'patient_id', 'created_by', 'updated_by'];

    public function patient() {
        return $this->belongsTo('App\Patient');
    }

    public function billcomponents() {
        return $this->hasMany('App\BillComponents');
    }

}
