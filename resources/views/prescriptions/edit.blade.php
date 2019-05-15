@extends('layouts.main')
@section('title')
    <title>Vet N Pet - New User</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Prescription {{$prescription->id}}</h4>
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
                    <h4 class="card-title" style="text-align: center">Edit Prescription</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['PrescriptionController@update', $prescription->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('appointment_id', 'Appointment:') !!}
                        {!! Form::select('appointment', $prescription , $prescription->appointment->id , ['class'=>'form-control', 'disabled'=>'disabled']) !!}
                        {!! Form::text('appointment_id', $prescription->appointment->id , ['class'=>'form-control', 'hidden'=>'hidden']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('symptoms', 'Symptoms:') !!}
                        {!! Form::select('symptoms[]', $symptoms , $prescription->symptoms->lists('id')->all(), ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('diagnoses', 'Diagnoses:') !!}
                        {!! Form::select('diagnoses[]', $diagnoses , $prescription->diagnosis->lists('id')->all() , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                    </div>

                    <div id="medicine">
                        <h3 class="float-left">Medicines</h3>
                        <a onclick="addmedicine()" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
                        <br>
                        <br>
                        @foreach($prescription->medicinedets as $d)
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('medicines', 'Medicines:') !!}
                                        {!! Form::select('medicines[]', $medicines->lists('name', 'id')->all(), $d->medicine->id, ['class'=>'form-control select32']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="timing">Timings:</label>
                                        @php
                                            $opts = array('M','A','N','MA','AN','MN','MAN');
                                        @endphp
                                        <select name='timing[]' class="form-control">

                                            @foreach($opts as $opt)
                                                <option value="{{$opt}}" @if($opt == $d->timing) selected @endif>{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="duration">Duration:</label>
                                        <input type="text" name='duration[]' value='{{$d->duration}}'  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1"><a class='btn btn-warning remove'><i class='fa fa-minus'></i></a></div>
                            </div>
                        @endforeach
                    </div>


                    <div class="form-group">
                        {!! Form::label('notes', 'Notes:') !!}
                        {!! Form::textarea('notes',$prescription->notes,['class'=>'form-control', 'rows' => 5, 'cols' => 40]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('reminder', 'Reminder:') !!}
                        {!! Form::date('reminder', $prescription->reminder, ['class'=>'form-control']) !!}
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Prescription', ['class'=>'btn btn-primary btn-block']) !!}
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