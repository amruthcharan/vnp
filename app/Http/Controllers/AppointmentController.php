<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\Patient;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $patients = Patient::lists('name','id');
        $docs = User::all('name','id','role_id')->where('role_id',2);
        $doctors=[];
        foreach($docs as $doc){
            $key = $doc->id;
            $value = $doc->name;
            $doctors = $doctors + array($key=>$value);
        }
        //return $doctors;
        return view('appointments.create', compact(['patients','doctors']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        //
        $input = $request->all();
        $input['created_by'] = Auth::user()->name;
        Appointment::create($input);
        $notification = array(
            'message' => 'Appointment has been booked!',
            'alert-type' => 'success',
            'head' => 'Success'
        );

        //redirecting back to users
        return redirect('/appointments')->with($notification);
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
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::lists('name','id');
        $docs = User::all('name','id','role_id')->where('role_id',2);
        $doctors=[];
        foreach($docs as $doc){
            $key = $doc->id;
            $value = $doc->name;
            $doctors = $doctors + array($key=>$value);
        }
        return view('appointments.edit', compact(['appointment','patients','doctors']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, $id)
    {
        //
        $input = $request->all();
        $appointment = Appointment::find($id);
        $input['updated_by'] = Auth::user()->name;
        $appointment->update($input);
        $notification = array(
            'message' => 'Appointment has been updated!',
            'alert-type' => 'info',
            'head' => 'Updated'
        );
        return redirect('/appointments')->with($notification);
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
