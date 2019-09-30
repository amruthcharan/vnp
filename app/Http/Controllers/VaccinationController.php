<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Vaccination;
use App\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vaccinations = Vaccination::all();
        return view('vaccinations.index', compact('vaccinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vaccines = Vaccine::lists('name', 'id');
        $patients = Patient::lists('id','id');
        return view('vaccinations.create', compact(['vaccines', 'patients']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $date = Carbon::parse($input['date']);
        $v = Vaccine::find($input['vaccine_id']);
        $input['expiry'] = $date->addMonths($v->validity);
        Vaccination::create($input);
        return redirect('/vaccinations');
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
        $vaccination = Vaccination::findOrFail($id);
        $vaccines = Vaccine::lists('name', 'id');
        return view('vaccinations.edit', compact(['vaccination', 'vaccines']));
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
        $input = $request->all();
        $vaccination = Vaccination::find($id);
        $date = Carbon::parse($input['date']);
        $v = Vaccine::find($input['vaccine_id']);
        $input['expiry'] = $date->addMonths($v->validity);
        $vaccination->update($input);
        return redirect('/vaccinations');
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
