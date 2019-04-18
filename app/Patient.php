<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = ['species_id', 'name', 'age', 'color', 'breed', 'user_id', 'owner_id', 'created_by', 'updated_by'];

    public function owner(){
        return $this->belongsTo('App\Owner');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function species(){
        return $this->belongsTo('App\Species');
    }
}
