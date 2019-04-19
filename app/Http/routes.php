<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

use App\Appointment;
use App\Bill;
use App\Prescription;
use Carbon\Carbon;

Route::auth();

//Route Group with Auth Middleware
Route::group(['middleware'=>'auth'], function (){

    //Dashboard Route
    Route::get('/', 'HomeController@index');

    //Users Route
    Route::resource('/users', 'UserController');

    //owners Routes
    Route::resource('/owners', 'OwnerController');

    //Patients Routes
    Route::resource('/patients', 'PatientController');

    //Appointments routes
    Route::resource('/appointments', 'AppointmentController');

    //Prescription routes
    Route::resource('/prescriptions', 'PrescriptionController');

    Route::get('/prescriptions/{id}/print', function ($id){
        $prescription = Prescription::findOrFail($id);
        return view('prescriptions.print', compact('prescription'));
    });



    //symptom routes
    Route::resource('/symptoms', 'SymptomController');

    //Diagnoses routes
    Route::resource('/diagnoses', 'DiagnosisController');

    //medicine routes
    Route::resource('/medicines', 'MedicineController');

    //billing routes
    Route::resource('/bills', 'BillingController');
    Route::get('/bills/{id}/print', function ($id){
        $bill = Bill::findOrFail($id);
        return view('bills.print', compact('bill'));
    });

    //notifications route
    Route::get('/notifications', function (){
        return view('errors.503');
    });

    //reminders route

    Route::get('/reminders', function (){
        $t = date('Y-m-d');
        //return $t;
        $reminders = DB::table('prescriptions')->where('reminder','>=' , $t)->get();

        return view('reminders', compact('reminders'));
    });
});