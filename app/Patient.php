<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = ['species_id','ownername', 'address', 'mobile', 'email', 'name', 'age', 'color', 'breed', 'created_by', 'updated_by'];

    protected $dates = ['age'];

    public function species(){
        return $this->belongsTo('App\Species');
    }
    public function appointments(){
        return $this->hasMany('App\Appointment');
    }

    public function bills(){
        return $this->hasMany('App\Bill');
    }
}
