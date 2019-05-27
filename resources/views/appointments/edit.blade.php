@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Update Appointment</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Appointment</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointment</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
@endsection
@section('content')
    <div class="row" style="margin: 0 auto">
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">Edit Appointment</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['AppointmentController@update',$appointment->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('patient_id', '* Patient:') !!}
                        {!! Form::text('patient_id', $appointment->patient->name , ['class'=>'form-control', 'readonly'=>'readonly ']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('doctor_id', '* Doctors:') !!}
                        {!! Form::select('doctor_id', $doctors , $appointment->doctor_id , ['class'=>'form-control']) !!}
                    </div>
                    @php
                        $date = \Carbon\Carbon::now();
                    @endphp
                    <div class="form-group">
                        {!! Form::label('date', '* Date:') !!}
                        {!! Form::date('date', $appointment->date, ['class'=>'form-control', 'min'=>$date->toDateString()]) !!}
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Appointment', ['class'=>'btn btn-dribbble btn-block']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select22').select2();
        });
        $('.select32').select2({
            placeholder: "Select an Option",
            tags: true,
            tokenSeparators: [","],
            createTag: function(newTag) {
                return {
                    id: newTag.term,
                    text: newTag.term + ' (new)'
                };
            }
        });
    </script>
@endsection