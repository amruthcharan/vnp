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
use App\Medicine;
use App\Patient;
use App\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

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

    //Reports route
    Route::get('/reports', function (){
        $start = Input::get('start');
        $end = Input::get('end');
        if(isset($start) and isset($end)){
            $type = Input::get('type');
            switch ($type){
                case 'bills':
                    $d = Bill::all()->filter(function ($bill){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $bill->created_at >= $start and $bill->created_at <= $end;
                    });
                    $total = Bill::all()->filter(function ($bill){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $bill->created_at >= $start and $bill->created_at <= $end;
                    })->sum('nettotal');
                    foreach ($d as $bill) {
                        $bill->pat = $bill->patient;
                        $bill->tot = $total;
                    }
                    break;
                case 'patients':
                    $d = Patient::all()->filter(function ($patient){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $patient->created_at >= $start and $patient->created_at <= $end;
                    });
                    foreach ($d as $pat) {
                        $pat->spe = $pat->species;
                    }
                    break;
                case 'appointments':
                    $d = Appointment::all()->filter(function ($app){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $app->date >= $start and $app->date < $end;
                    });
                    foreach ($d as $app) {
                        $app->pat = $app->patient;
                        $app->doc = $app->doctor;
                    }
                    break;
                case 'prescriptions':
                    $d = Prescription::all()->filter(function ($pre){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $pre->created_at >= $start and $pre->created_at <= $end;
                    });
                    foreach ($d as $pre) {
                        $pre->pat = $pre->appointment->patient;
                        $pre->doc = $pre->appointment->doctor;
                        $pre->app = $pre->appointment;

                    }
                    break;
            }
            $res =  json_encode($d);
            return Response::json($res);
        } else {
            $bills = Bill::all()->filter(function($bill) {
                $t = date('Y-m-d');
                return $bill->created_at == $t;
            });
            $total = Bill::all()->filter(function($bill) {
                $t = date('Y-m-d');
                return $bill->created_at == $t;
            })->sum('nettotal');
            //return $total;
            return view('reports',compact(['bills','total']));
        }
    });

    //reminders route

    Route::get('/reminders', function (){

        $reminders = Prescription::all()->filter(function ($pre){
            $t = date('Y-m-d');
            $ti = Carbon::now()->addDays(7)->format('Y-m-d');
            return $pre->reminder >= $t and $pre->reminder < $ti;
        });
        return view('reminders', compact('reminders'));
    });

    Route::post('/getad', function (\Illuminate\Http\Request $request){
        $input = $request->all();
        $id = $input['id'];
        $app = Appointment::findOrFail($id);

        $res = array(
            'status' => 'success',
            'ownername' => $app->patient->ownername,
            'name' => $app->patient->name,
            'species' => $app->patient->species->name,
            'age' => $app->patient->age->diff(Carbon::now())->format('%y years, %m months and %d days'),
            'breed' => $app->patient->breed,
            'color' => $app->patient->color,
            'date' => $app->date,
            'pre' => $app->patient->appointments,
        );
        return Response::json($res);
    });

    Route::post('/getped', function (\Illuminate\Http\Request $request){
        $input = $request->all();
        $id = $input['id'];
        $app = Appointment::findOrFail($id);

        $res = array(
            'status' => 'success',
            'pres' => $app->prescription->id,
            'symptoms' => $app->prescription->symptoms,
            'diagnoses' => $app->prescription->diagnosis,
            'medicinedets' => $app->prescription->medicinedets,
            'notes'=>$app->prescription->notes,
        );
        return Response::json($res);
    });

    Route::get('/getmn/{id}', function ($id){

        $app = Medicine::findOrFail($id);

        $res = array(
            'status' => 'success',
            'name' => $app->name,
        );
        return Response::json($res);
    });

    Route::post('/getpd', function (\Illuminate\Http\Request $request){
        $input = $request->all();
        $id = $input['id'];
        $patient = \App\Patient::findOrFail($id);

        $res = array(
            'status' => 'success',
            'ownername' => $patient->ownername ? $patient->ownername: '',
            'name' => $patient->name ? $patient->name : '',
            'species' => $patient->species ? $patient->species->name : '',
            'age' => $patient->age ? $patient->age->diff(Carbon::now())->format('%y years, %m months and %d days') : '',
            'breed' => $patient->breed ? $patient->breed : '',
            'color' => $patient->color ? $patient->color : '',
        );
        return Response::json($res);
    });
    Route::get('/getdata', function (){
        return view('getdata');
    });
    Route::post('/createpat', function(\Illuminate\Http\Request $request){
        $input = $request->all();
        $input['created_by']='Online API';
        $pat = Patient::create($input);
        return Response::json($pat);
    });
    Route::post('/createapp', function (\App\Http\Requests\AppointmentRequest $request){
        $input = $request->all();
        $input['created_by'] = 'Created by API';
        $app = Appointment::create($input);
        return Response::json($app);
    });



});