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
use App\Vaccination;
use App\Vaccine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    //Vaccination Routes
    Route::resource('/vaccinations', 'VaccinationController');

    Route::get('/prescriptions/{id}/print', function ($id){
        $prescription = Prescription::findOrFail($id);
        $vaccines = Vaccine::all();
        return view('prescriptions.print', compact(['prescription', 'vaccines']));
    });



    //symptom routes
    Route::resource('/symptoms', 'SymptomController');

    //Diagnoses routes
    Route::resource('/diagnoses', 'DiagnosisController');

    //medicine routes
    Route::resource('/medicines', 'MedicineController');

    //vaccines routes
    Route::resource('/vaccines', 'VaccineController');

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
                        return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
                    });
                    $total = Bill::all()->filter(function ($bill){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $bill->created_at->format('Y-m-d') > $start and $bill->created_at->format('Y-m-d') <= $end;
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
                        return $patient->created_at->format('Y-m-d') > $start and $patient->created_at->format('Y-m-d') <= $end;
                    })->load('species');
                    break;
                case 'appointments':
                    $d = Appointment::all()->filter(function ($app){
                        $start = Input::get('start');
                        $end = Input::get('end');
                        return $app->date > $start and $app->date <= $end;
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
                        return $pre->created_at->format('Y-m-d') > $start and $pre->created_at->format('Y-m-d') <= $end;
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
        $t = date('Y-m-d');
        $reminders = Appointment::where('date', '>=', $t)->get()->load('prescription')->all();
        //return $reminders;
        return view('reminders', compact('reminders'));
    });
    Route::get('/getvac/{id}', function($id){
        $vaccination = Vaccination::where('patient_id',$id)
            ->select(DB::raw('*, max(expiry) as expiry'))
            ->orderBy('expiry', 'desc')
            ->groupBy('vaccine_id')
            ->get()->toArray();
        return Response::json($vaccination);
    });

    Route::post('/getad', function (\Illuminate\Http\Request $request){
        $input = $request->all();
        $id = $input['id'];
        $app = Appointment::findOrFail($id);
        $vaccines = Vaccine::all();
        //$vaccinations = Vaccination::where('patient_id',$app->patient_id)->groupBy('vaccine_id')->latest('expiry')->get();
        $vaccinations = Vaccination::where('patient_id',$app->patient_id)
            ->select(DB::raw('*, max(expiry) as expiry'))
            ->orderBy('expiry', 'desc')
            ->groupBy('vaccine_id')
            ->get();
        $res = array(
            'status' => 'success',
            'id' => $app->patient->id? $app->patient->id : "",
            'ownername' => $app->patient->ownername ? $app->patient->ownername : "",
            'name' => $app->patient->name ? $app->patient->name : '',
            'species' => $app->patient->species ? $app->patient->species->name : '',
            'age' => $app->patient->age ? $app->patient->age->format('d-m-Y') : '',
            'breed' => $app->patient->breed ? $app->patient->breed : '',
            'feeding_pattern' => $app->patient->feeding_pattern ? $app->patient->feeding_pattern : '',
            'date' => $app->date ? $app->date : '',
            'pre' => $app->patient->appointments,
            'vaccinations' => $vaccinations,
            'vaccines' => $vaccines,
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
    Route::get('/getpreid/{id}',function($id){
        $app = Appointment::findOrFail($id)->load('prescription');
        $res = array(
            'status'=>'success',
            'preid'=> $app->prescription->id
        );
        //return $app;
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
            'id'=> $patient->id ? $patient->id: '',
            'ownername' => $patient->ownername ? $patient->ownername: '',
            'name' => $patient->name ? $patient->name : '',
            'species' => $patient->species ? $patient->species->name : '',
            'age' => $patient->age ? $patient->age->format('d-m-Y') : '',
            'breed' => $patient->breed ? $patient->breed : '',
            'color' => $patient->color ? $patient->color : '',
        );
        return Response::json($res);
    });
    Route::get('/getdata', function (){
        return view('getdata');
    });
    Route::get('/onlineapps', function (){
        return view('onlineapps');
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
        $res = $app;
        $res->doctor = $app->doctor->name;
        $res->doctor = $app->patient->name;
        $username="vetnpet";

        $password="8215427";

        $d = date_create($app->date);

        $date = date_format($d,'d/m/Y');

        $message="Dear Customer, Appointment has been successfully booked for your pet, " . $app->patient->name ? $app->patient->name : ''. " on " . $date . ". Your Appointment id is " . $app->id . ". @ VetnPet Hoptial Film Nagar";

        $sender="VetPet"; //ex:INVITE

        $mobile_number=$app->patient->mobile;


        $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);

        return Response::json($app);
    });
    Route::get('/getonlineapps', function (){
        $t = date('Y-m-d');
        $apps = Appointment::where('created_by', 'Created by API')->where('date', '>=', $t)->orderBy('date')->get()->load('patient')->all();
        //return $apps;
        $res =  json_encode($apps);
        return Response::json($res);

    });

    Route::get('/sendsms/{id}', function ($id){
        $app = Appointment::findOrFail($id);
        //sms code
        $username="vetnpet";
        $password="8215427";
        $d = date_create($app->date);
        $date = date_format($d,'d/m/Y');
        $message="Dear Customer, Reminder about the appointment for your pet, " . $app->patient->name ? $app->patient->name : '' . " on " . $date . ". Your Appointment id is " . $app->id . ". @ VetnPet Hoptial Film Nagar";
        $sender="VetPet"; //ex:INVITE
        $mobile_number=$app->patient->mobile;
        $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        // sms code
        $res = array(
            'status'=>'success'
        );
        return Response::json($output);
    });

    Route::get('/sendreminders', function (){
        $t = date('Y-m-d');
        Appointment::whereDate('date','<',$t)->where('status','=','Scheduled')->update(['status'=>'Expired']);
        $apps = Appointment::where('date',$t)->get()->all();
        $res = [];
        foreach($apps as $app){
            //sms code
            $username="vetnpet";
            $password="8215427";
            $d = date_create($app->date);
            $date = date_format($d,'d/m/Y');
            $message="Dear Customer, Reminder about the appointment for your pet, " . $app->patient->name ? $app->patient->name : '' . " on " . $date . ". Your Appointment id is " . $app->id . ". @ VetnPet Hoptial Film Nagar";
            $sender="VetPet"; //ex:INVITE
            $mobile_number=$app->patient->mobile;
            $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $r = array($output);
            array_push($res,$r);
        }

        return Response::json($res);
    });

    Route::get('/quickapp/{id}', function($id){
        $input['patient_id'] = $id;
        $authUser = auth()->user();
        //return $authUser;
        if($authUser->role_id == 2){
            $input['doctor_id'] = $authUser->id;
        } else {
            $input['doctor_id'] = 2;
        }
        $input['date'] = date('Y-m-d');
        $input['created_by']= "Created via QuickApp";
        $app=Appointment::create($input);
        return Response::json($app);
    });

});