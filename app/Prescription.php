<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    //
    protected $fillable = ['appointment_id', 'notes', 'reminder'];

    public function appointment() {
        return $this->belongsTo('App\Appointment');
    }

    public function symptoms() {
        return $this->belongsToMany('App\Symptom', 'symptom_prescription',  'prescription_id','symptom_id');
    }

    public function diagnosis() {
        return $this->belongsToMany('App\Diagnosis', 'diagnosis_prescription',  'prescription_id','diagnosis_id');
    }

    public function medicinedets() {
        return $this->hasMany('App\MedicineDetails');
    }

}
