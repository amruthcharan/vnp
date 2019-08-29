<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Diagnosis;
use App\Http\Requests\PrescriptionRequest;
use App\Medicine;
use App\MedicineDetails;
use App\Patient;
use App\Prescription;
use App\Symptom;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $prescriptions = Prescription::all();

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $docs = User::all('name','id','role_id')->where('role_id',2);
        $appointments = Appointment::lists('id','id');
        $symptoms = Symptom::lists('name','id');
        $diagnoses = Diagnosis::lists('name','id');
        $medicines = Medicine::all();
        //return $medicines;
        return view('prescriptions.create',compact(['appointments','symptoms','diagnoses', 'medicines']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionRequest $request)
    {
        //
        $input = $request->all();

        $symptoms= $request->symptoms;
        if($symptoms <> "") {
            for ($i = 0; $i < count($symptoms); $i++) {
                if (intval($symptoms[$i]) == 0) {
                    $symp = array('name' => $symptoms[$i]);
                    $newsymptom = Symptom::create($symp);
                    $symptoms[$i] = $newsymptom->id;

                } else {
                    $symptoms[$i] = intval($symptoms[$i]);
                }
            }
        }
        $diagnoses= $request->diagnoses;
        if($diagnoses <> "") {
            for ($i = 0; $i < count($diagnoses); $i++) {
                if (intval($diagnoses[$i]) == 0) {
                    $symp = array('name' => $diagnoses[$i]);
                    $newdiagnosis = Diagnosis::create($symp);
                    $diagnoses[$i] = $newdiagnosis->id;
                } else {
                    $diagnoses[$i] = intval($diagnoses[$i]);
                }
            }
        }


        $input['symptoms'] = $symptoms;
        $input['diagnoses'] = $diagnoses;
        $input['created_by'] = Auth::user()->name;
        $prescription = Prescription::create($input);
        $prescription->Diagnosis()->sync($diagnoses, false);
        $prescription->Symptoms()->sync($symptoms,false);

        $app = array(
            'doctor_id'=>$prescription->appointment()->get()->all()[0]->doctor_id,
            'patient_id'=>$prescription->appointment()->get()->all()[0]->patient_id,
            'date'=>$prescription->reminder,
            'created_by' => "Added Automatically by System Reminders"
        );

        $appl = Appointment::create($app);
        //sms code
        $username="vetnpet";
        $password="8215427";
        $d = date_create($appl->date);
        $date = date_format($d,'d/m/Y');
        $message="Dear Customer, Appointment has been successfully booked for your pet, " . $appl->patient->name . " on " . $date . " with Dr." . $appl->doctor->name . ". Your Appointment id is " . $appl->id . ".";
        $sender="VetPet"; //ex:INVITE
        $mobile_number=$appl->patient->mobile;
        $url = "login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        // sms code
        $medicines = $request->medicines;
        $timing = $request->timing;
        $duration = $request->duration;
        if($medicines <> "") {
            for ($i = 0; $i < count($medicines); $i++) {
                //return $medicines[$i];
                if (intval($medicines[$i]) == 0) {
                    $symp = array('name' => $medicines[$i]);
                    $newmedicine = Medicine::create($symp);
                    $medicines[$i] = $newmedicine->id;
                } else {
                    $medicines[$i] = intval($medicines[$i]);
                }
                $medicinedetails = array('prescription_id'=>$prescription->id, 'medicine_id'=>$medicines[$i],'timing'=>$timing[$i],'duration'=>$duration[$i]);
                MedicineDetails::create($medicinedetails);
            }
        }

        return redirect('/prescriptions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $prescription = Prescription::findOrFail($id);
        //return $prescription->medicinedets;
        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $prescription = Prescription::findOrFail($id);
        $medicines = Medicine::all();
        $symptoms = Symptom::lists('name','id');
        $diagnoses = Diagnosis::lists('name','id');
        return view('prescriptions.edit', compact(['prescription','medicines','diagnoses','symptoms']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionRequest $request, $id)
    {
        //
        //return $request->all();
        $prescription = Prescription::find($id);
        $input = $request->all();
        $symptoms= $request->symptoms;
        if($symptoms <> "") {
            for ($i = 0; $i < count($symptoms); $i++) {
                if (intval($symptoms[$i]) == 0) {
                    $symp = array('name' => $symptoms[$i]);
                    $newsymptom = Symptom::create($symp);
                    $symptoms[$i] = $newsymptom->id;

                } else {
                    $symptoms[$i] = intval($symptoms[$i]);
                }
            }
        }
        $diagnoses= $request->diagnoses;
        if($diagnoses <> "") {
            for ($i = 0; $i < count($diagnoses); $i++) {
                if (intval($diagnoses[$i]) == 0) {
                    $symp = array('name' => $diagnoses[$i]);
                    $newdiagnosis = Diagnosis::create($symp);
                    $diagnoses[$i] = $newdiagnosis->id;
                } else {
                    $diagnoses[$i] = intval($diagnoses[$i]);
                }
            }
        }


        $input['symptoms'] = $symptoms;
        $input['diagnoses'] = $diagnoses;
        $input['updated_by'] = Auth::user()->name;
        $prescription->update($input);
        $prescription->Diagnosis()->sync($diagnoses, true);
        $prescription->Symptoms()->sync($symptoms,true);

        $medicine = $prescription->medicinedets()->get();
        $medicines = $request->medicines;
        $timing = $request->timing;
        $duration = $request->duration;

        foreach ($medicine as $d){
            $i = $d->id;
            MedicineDetails::find($i)->delete();
        }


        if($medicines <> "") {
            for ($i = 0; $i < count($medicines); $i++) {
                //return $medicines[$i];
                if (intval($medicines[$i]) == 0) {
                    $symp = array('name' => $medicines[$i]);
                    $newmedicine = Medicine::create($symp);
                    $medicines[$i] = $newmedicine->id;
                } else {
                    $medicines[$i] = intval($medicines[$i]);
                }
                $medicinedetails = array('prescription_id'=>$prescription->id, 'medicine_id'=>$medicines[$i],'timing'=>$timing[$i],'duration'=>$duration[$i]);
                MedicineDetails::create($medicinedetails);
            }
        }
        return redirect('/prescriptions/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
