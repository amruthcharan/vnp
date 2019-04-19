@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New Prescription</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">New Prescription</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Prescriptions</li>
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
        <div class="col-md-9"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">New Prescription</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'PrescriptionController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('appointment_id', 'Appointment:') !!}
                            {{ csrf_field() }}
                            {!! Form::select('appointment_id', $appointments , app('request')->input('appid') ? app('request')->input('appid') : null , ['class'=>'form-control select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('symptoms', 'Symptoms:') !!}
                            {!! Form::select('symptoms[]', $symptoms , null , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('diagnoses', 'Diagnoses:') !!}
                            {!! Form::select('diagnoses[]', $diagnoses , null , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                        </div>

                        {{--<div id="medicine">
                            <h4 class="float-left">Previous Records</h4>
                            @php
                                $prescription = \App\Prescription::find(1);
                            @endphp
                            @foreach($prescription->appointment->patient->appointments as $appointment)
                            <span>&nbsp;</span>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#pre"  class="btn btn-dark btn-xs">1</a>
                            @endforeach
                                <br>
                            <br>
                        </div>--}}
                        <div id="medicine">
                            <h3 class="float-left">Medicines</h3>
                            <a onclick="addmedicine()" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
                            <br>
                            <br>
                        </div>

                        <div class="form-group">
                            {!! Form::label('notes', 'Notes:') !!}
                            {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => 5, 'cols' => 40]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('reminder', 'Reminder:') !!}
                            {!! Form::date('reminder', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                {!! Form::submit('Add Prescription', ['class'=>'btn btn-primary btn-block']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('includes.premodal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select22').select2();
    });

    $('.select32').select2({
        placeholder: "Start typing...",
        tags: true,
        tokenSeparators: [","],
        createTag: function(newTag) {
            return {
                id: newTag.term,
                text: newTag.term + ' (new)'
            };
        }
    });
    
    function addmedicine() {
        $('#medicine').append("<div class=\"row align-items-center\"><div class=\"col-md-4\"><div class=\"form-group\"><label for=\"medicine\">Medicine:</label><select name='medicines[]' class=\"form-control select32\">@foreach($medicines as $medicine)<option value='{{$medicine->id}}'>{{$medicine->name}}</option>@endforeach</select></div></div><div class=\"col-md-3\"><div class=\"form-group\"><label for=\"timing\">Timings:</label><select name='timing[]' class=\"form-control\"><option>M</option><option>A</option><option>N</option><option>MA</option><option>AN</option><option>MN</option><option>MAN</option></select></div></div><div class=\"col-md-4\"><div class=\"form-group\"><label for=\"duration\">Duration:</label><input type=\"text\" name='duration[]' class=\"form-control\"></div></div><div class=\"col-md-1\"><a class='btn btn-warning remove'><i class='fa fa-minus'></i></a></div></div>");
        $('.select32').select2({
            placeholder: "Start typing...",
            tags: true,
            tokenSeparators: [","],
            createTag: function (newTag) {
                return {
                    id: newTag.term,
                    text: newTag.term + ' (new)'
                };
            }
        });
    }
    $(document).on('click', '.remove', function (){
        $(this).closest('.row').remove();
    });
</script>

@endsection