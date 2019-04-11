@extends('layouts.main')
@section('title')
    <title>Vet N Pet - View Appointment</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">View Prescription</h4>
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
    <div class="row" id="printid">
        <div class="col-md-12">
            <div class="card card-body printableArea">
                <h3><b>Prescription #</b> <span class="pull-right">{{$prescription->id}}</span></h3>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left">
                            <address>
                                <h3> &nbsp;<b class="text-danger">Vet N Pet</b></h3>
                                <p class=" m-l-5">Plot No 369/1,
                                    <br/> Phase 3, Film Nagar
                                    <br/> Jubilee Hills
                                    <br/> Hyderabad - 500096</p>
                            </address>
                        </div>
                        <div class="float-right text-right">
                            <p class=""><b>Prescription Date :</b> <i class="fa fa-calendar"></i> {{$prescription->updated_at}}</p>
                            <address>
                                <h4>Prescription is For,</h4>
                                <p class="m-l-30">{{$prescription->appointment->patient->name}}
                                    <br/> {{$prescription->appointment->patient->owner->Address}},
                                    </p>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="m-t-20">Symptoms:</h4>
                        <div class="table-responsive" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-right">Symptom</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($prescription->symptoms as $d)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td class="text-right"> {{$d->name}} </td>
                                    </tr>
                                    @php
                                    $i++
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="m-t-20">Diagnoses:</h4>
                        <div class="table-responsive" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-right">Daignosis</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($prescription->diagnosis as $d)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td class="text-right">{{$d->name}}</td>
                                        @php
                                            $i++
                                        @endphp
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="m-t-20">Medicines List:</h4>
                        <div class="table-responsive" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Medicine</th>
                                    <th class="text-right">Timing</th>
                                    <th class="text-right">Duration</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                               @foreach($prescription->medicinedets as $d)
                                <tr>
                                    <td class="text-center">{{$i}}</td>
                                    <td>{{$d->medicine->name}}</td>
                                    <td class="text-right">
                                        {{$d->timing}}
                                    </td>
                                    <td class="text-right"> {{$d->duration}} </td>
                                </tr>
                                @php
                                    $i++
                                @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="text-right">
                            <a class="btn btn-info" href="{{route('prescriptions.edit',$prescription->id)}}"> Edit Prescription </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/libs/print/print.min.js')}}"></script>
@endsection