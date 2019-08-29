@extends('layouts.main')

@section('title')
    <title>Vet N Pet - Dashboard</title>
@endsection

@section('content')

    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover patients">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                    <h6 class="text-white">Patients</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover appointments">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
                    <h6 class="text-white">Appointments</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover reports">
                <div class="box bg-warning text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
                    <h6 class="text-white">Reports</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-hover reminders">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
                    <h6 class="text-white">Send Reminders</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Patients List</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Owner Name</th>
                            <th>Owner Mobile</th>
                            <th>Owner Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($patients as $p)
                        <tr>
                            <td>{{$p->name}}</td>
                            <td>{{$p->age ? $p->age->format('d-m-Y') : ''}}</td>
                            <td>{{$p->ownername}}</td>
                            <td>{{$p->mobile}}</td>
                            <td>{{$p->email}}</td>
                        </tr>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('scripts')
    <script>
        $('#zero_config').DataTable();

        $(document).on('click','.patients', function () {
            window.location.href = "/patients";
        });
        $(document).on('click','.appointments', function () {
            window.location.href = "/appointments";
        });
        $(document).on('click','.reports', function () {
            window.location.href = "/reports";
        });
        $(document).on('click','.reminders', function () {
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $.ajax({
                url : "/sendreminders",
                success:function(d){
                    console.log(d);
                },
                error:function (e) {
                    console.log(JSON.stringify(e));
                }
            });
        });

    </script>
@endsection