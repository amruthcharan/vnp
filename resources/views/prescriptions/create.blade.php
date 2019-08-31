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
        <div class="col-md-4 appdet" style="margin: 0 auto">
            <div class="card sticky-top">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="text-left">Patient's ID</td>
                            <td>:</td>
                            <td class="text-left patttid"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Owners Name</td>
                            <td>:</td>
                            <td class="text-left ownername"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Name</td>
                            <td>:</td>
                            <td class="text-left name"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Spicies</td>
                            <td>:</td>
                            <td class="text-left species"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Age</td>
                            <td>:</td>
                            <td class="text-left age"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Breed</td>
                            <td>:</td>
                            <td class="text-left breed"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Color</td>
                            <td>:</td>
                            <td class="text-left color"></td>
                        </tr>
                        <tr>
                            <td class="text-left">Appointment Date</td>
                            <td>:</td>
                            <td class="text-left date"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align: center">New Prescription</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'POST', 'action' => 'PrescriptionController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('appointment_id', 'Appointment:') !!}
                            {{ csrf_field() }}
                            {!! Form::select('appointment_id', $appointments , app('request')->input('appid') ? app('request')->input('appid') : null , ['class'=>'form-control appid select22']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('symptoms', 'Symptoms:') !!}
                            {!! Form::select('symptoms[]', $symptoms , null , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('diagnoses', 'Diagnoses:') !!}
                            {!! Form::select('diagnoses[]', $diagnoses , null , ['class'=>'form-control select32','multiple'=>'multiple']) !!}
                        </div>

                        <div id="pres">



                        </div>
                        <div id="medicine">
                            <br>
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
                            {!! Form::date('reminder', null, ['class'=>'form-control remdate']) !!}
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
    <!-- Modal  -->
    <div class="modal fade none-border" id="pre">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong></strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Symptoms</th>
                                    </tr>
                                    </thead>
                                        <tbody class="sym">

                                        </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Diagnoses</th>
                                    </tr>
                                    </thead>
                                        <tbody class="dia">

                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-left">Medicine</th>
                                <th>Timing</th>
                                <th class="text-right">Duration</th>
                            </tr>
                            </thead>
                                <tbody class="med">

                                </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 notes"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select22').select2();
        $('.appdet').hide();
        $('#pres').hide();

        var today = new Date();
        var dd = today.getDate()+1;
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();

        var today = mm + '/' + dd + '/' + yyyy;
        $('remdate').datepicker({
            minDate: today,
        });
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

    $('.appid').on('change', function () {
        getpdd();
    });

    if($('.appid')){
        getpdd();
    }

    function getpdd(){
        $('#pres').hide();
        $('#pres').html("<h4 class='float-left'>Previous Records</h4>");
        $('.appdet').hide();
        var token = '{{ Session::token() }}';
        var id = parseInt($('.appid').val());
        var url = '/getad' ;
        $.ajax({
            method: 'POST',
            url: url,
            data:{id : id, _token : token},
            success: function (res) {
                $('.patttid').text(res.id);
                $('.ownername').text(res.name);
                $('.name').text(res.ownername);
                $('.species').text(res.species);
                $('.age').text(res.age);
                $('.color').text(res.color);
                $('.breed').text(res.breed);
                $('.date').text(res.date);
                $('.appdet').show();
                res.pre.forEach(function (preapp) {
                    $("<span>&nbsp;</span><span class='btn btn-dark btn-xs apppre'>" + preapp.id +"</span>").appendTo('#pres');
                });
                $('#pres').show();
            }
        });
    }

    $(document).on('click','.apppre',function () {
        var id = $(this).text();
        var token = '{{ Session::token() }}';
        var url = '/getped';
        $.ajax({
            method: 'POST',
            url: url,
            data: {id: id, _token: token},
            success: function (d) {
                $('.modal-title').text("Prescription #" + d.pres);
                $('.sym').empty();
                d.symptoms.forEach(function (s) {
                    $("<tr><td class='text-left'>" + s.name +"</td></tr>").appendTo('.sym');
                });
                $('.dia').empty();
                d.diagnoses.forEach(function (s) {
                    $("<tr><td class='text-left'>" + s.name +"</td></tr>").appendTo('.dia');
                });
                $('.med').empty();

                d.medicinedets.forEach(function (s) {
                    var id = s.medicine_id;
                    var token = '{{ Session::token() }}';
                    var url = '/getmn/' +id ;
                    $.ajax({
                        method: 'GET',
                        url: url,
                        /*data:{id : id, _token : token},*/
                        success: function (res) {
                           var medname = res.name;
                            $("<tr><td class='text-left'>" + medname +"</td><td>"+s.timing+"</td><td class='text-right'>"+s.duration+"</td></tr>").appendTo('.med');
                        }
                    });
                });
                $('.notes').empty();
                $('.notes').append('Notes - <span>'+ d.notes +'</span>');
                $('#pre').modal();
            },
            error: function(){
                alert('No prescription found');
            }
        });
    });

</script>

@endsection