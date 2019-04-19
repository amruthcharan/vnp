@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New Appointment</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add New Appointment</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
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
                    <h4 class="card-title" style="text-align: center">Register</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'AppointmentController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('patient_id', '* Patient:') !!}
                            {!! Form::select('patient_id', $patients , app('request')->input('patid') ? app('request')->input('patid') : null , ['class'=>'form-control select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('doctor_id', '* Doctor:') !!}
                            {!! Form::select('doctor_id', $doctors , null , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('date', '* Date:') !!}
                            {!! Form::date('date', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                {!! Form::submit('Book Appointment', ['class'=>'btn btn-primary btn-block']) !!}
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
        placeholder: "Select or add species",
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