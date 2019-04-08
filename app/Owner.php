<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //

    protected $fillable = ['name', 'address', 'mobile', 'email'];

    public function patient(){
        return $this->hasOne('App\Owner');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }


}
