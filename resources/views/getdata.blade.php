@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Online Appointments</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Online Appointments</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Appointment Requests</h4>
                        <button class='btn btn-primary btn-sm float-right getrequests'><i class="ti-plus"></i><strong> Get Requests</strong></button>
                    </div>

                    <div class="table-responsive">
                        <table id="appointments" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Owner Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="tbody">

                            </tbody>
                        </table>
                        <span style='text-align: center;' class="error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal  -->
    <div class="modal fade none-border" id="appmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                @php
                    use App\User;
                    $doctors = User::all('name','id','role_id')->where('role_id',2);
                    /*$doctors=[];
                    foreach($docs as $doc){
                        $key = $doc->id;
                        $value = $doc->name;
                        $doctors = $doctors + array($key=>$value);
                    }*/
                @endphp

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="patiid">Patient ID:</label>
                                    <input type="text" class="form-control" id="patiid" readonly>
                                </div>
                            @php
                                $d = \Carbon\Carbon::now();
                            @endphp
                                <div class="form-group">
                                    <label for="patidate">Date:</label>
                                    <input type="date" class="form-control" min="{{$d->toDateString()}}" id="patidate">
                                </div>
                                <div class="form-group">
                                    <label for="doctor">Doctor:</label>
                                    <select class="form-control" id="doctor_id">
                                        @foreach($doctors as $doctor)
                                        <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <div style="text-align:center;">

                                <a class="btn btn-default" style="color:white;" id="createapp"> Create Appointment</a>
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
@endsection


@section('scripts')
    <script>
        $('#appointments').DataTable();

        function getdetails(){
            var actionbtn;
            var url = 'http://vnpapi.aresol.in/apps/read.php';
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $('error').empty();
            $.ajax({
                url: url,
                success:function(d){
                    $('.tbody').empty();
                    $('error').empty();
                    $.each(d.records, function(k,v){
                        if(v.patid==0){
                            actionbtn = "<button class='btn btn-danger crepat'>Create Patient</button>";
                        } else {
                            actionbtn = "<button class='btn btn-dribbble creapp'>Create Appointment</button>";
                        }
                        $('.tbody').append("<tr><td>" + v.patid + "</td><td>" + v.name + "</td><td>" + v.ownername + "</td><td>" + v.mobile + "</td><td>" + v.email + "</td><td>" + v.date + "</td><td>" + actionbtn + "</td><td class='id' style='display: none;'>" + v.id + "</td></tr>");

                    });
                },
                error:function (d) {
                    $('.tbody').empty();
                    $('.error').append("<h3>"+d.responseJSON.message+"</h3>");
                }
            });
        }

        $('.getrequests').on('click',function(){
            getdetails();
        });

        $('table').delegate('.crepat','click', function(){
            var name = $(this).closest('tr').find('td').eq(1).html();
            var oname = $(this).closest('tr').find('td').eq(2).html();
            var mobile = $(this).closest('tr').find('td').eq(3).html();
            var email = $(this).closest('tr').find('td').eq(4).html();
            var id = $(this).closest('tr').find('.id').html();
            var token = '{{ Session::token() }}';
            var patid = null;
            var pat = {name:name,ownername:oname,mobile:mobile,email:email,_token:token};
            $.ajax({
                url:'/createpat',
                async:false,
                type:"POST",
                data: pat,
                success:function (d) {
                    patid=d.id;
                }
            });

            var det = {patid:patid,status:'created',id:id};
            var json = JSON.stringify(det);
            $.ajax({
                url:'http://vnpapi.aresol.in/apps/update.php',
                async:false,
                type:"POST",
                data: json,
                dataType: "json",
                success:function (d) {
                    toastr.success("Patient has been created", "Success");
                }
            });
            var actionbtn = "<button class='btn btn-dribbble creapp'>Create Appointment</button>";
            $(this).closest('tr').find('td').eq(0).html(patid);
            $(this).closest('tr').find('td').eq(6).html(actionbtn);
        });
        var apiid;
        $('table').delegate('.creapp','click', function(){
            var pid = $(this).closest('tr').find('td').eq(0).html();
            var date = $(this).closest('tr').find('td').eq(5).html();
            apiid = $(this).closest('tr').find('.id').html();
            $('#patiid').val(pid);
            $('#patidate').val(date);
            $('#appmodal').modal();
        });

        $('#createapp').on('click', function () {
            var token = '{{ Session::token() }}';
            var pid = $('#patiid').val();
            var date = $('#patidate').val();
            var doctorid = $('#doctor_id').val();

            $('#appmodal').modal('toggle');

            //console.log(pid, date, doctorid);

            var app = {patient_id:pid,doctor_id:doctorid,date:date,_token:token};
            $.ajax({
                url:'/createapp',
                async:false,
                type:"POST",
                data: app,
                success:function (d) {
                    patid = d.patient_id;
                    date=d.date;
                    appid=d.id;
                    doctor=d.doctor.name;
                    petname=d.patient.name;
                    mobile=d.patient.mobile;
                    console.log(d);
                }
            });
            var det = {patid:patid,status:'Appointment Booked',appid:appid,doctor:doctor,petname:petname,date:date,id:apiid};
            var json = JSON.stringify(det);
            console.log(json);
            $.ajax({
                url:'http://vnpapi.aresol.in/apps/update.php',
                async:false,
                type:"POST",
                data: json,
                dataType: "json",
                success:function (d) {
                    toastr.success("Appointment has been created", "Success");
                }
            });
            getdetails();
        })

    </script>
@endsection