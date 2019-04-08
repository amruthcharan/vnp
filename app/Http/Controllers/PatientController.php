<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Patient;
use App\Species;
use Illuminate\Http\Request;

use App\Http\Requests;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $owners = Owner::lists('name','id');
        $species = Species::lists('name', 'id');
        return view('patients.create', compact(['owners','species']));
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
        $input = $request->all();
        $species['name'] = $input['species_id'];
        if(is_string($species['name'])){
            $newspecies = Species::create($species);
            $input['species_id'] = $newspecies->id;
        }
        Patient::create($input);
        $notification = array(
            'message' => 'patient has been created!',
            'alert-type' => 'success',
            'head' => 'Success'
        );
        return redirect('/patients')->with($notification);
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
        $patient = Patient::findOrFail($id);
        $species = Species::lists('name','id');
        $owners = Owner::lists('name','id');
        return view('patients.edit', compact(['patient','species','owners']));
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
        $input = $request->all();
        $species['name'] = $input['species_id'];
        if(is_string($species['name'])){
            $newspecies = Species::create($species);
            $input['species_id'] = $newspecies->id;
        }
        $patient = Patient::find($id);
        $patient->update($input);
        $notification = array(
            'message' => 'patient has been updated!',
            'alert-type' => 'info',
            'head' => 'Update'
        );
        return redirect('/patients')->with($notification);


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
