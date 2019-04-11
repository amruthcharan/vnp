<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Diagnosis;
use App\Medicine;
use App\MedicineDetails;
use App\Prescription;
use App\Symptom;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

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
    public function store(Request $request)
    {
        //
        //return $request->all();
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

        $prescription = Prescription::create($input);
        $prescription->Diagnosis()->sync($diagnoses, false);
        $prescription->Symptoms()->sync($symptoms,false);

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
    public function update(Request $request, $id)
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
