@extends('layouts.main')
@section('title')
    <title>Vet N Pet - {{$patient->name}}</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">{{$patient->name}}</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <span class="text-right"><a class="btn btn-sm btn-success" onclick="window.history.back();">back</a></span>
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
        <!-- column -->
        <div class="col-md-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Owner Details</h4>
                        <a class='float-right' href="{{route('patients.edit',$patient->id)}}"><i class="ti-pencil-alt"></i></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">Owner Name</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->ownername}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Mobile Number</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->mobile}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Email Address</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->email}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Address</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->address}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Appointments</h4>
                        <a class='float-right' href="{{route('appointments.create','patid='.$patient->id)}}"><b><i class="ti-plus"></i></b></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            @foreach($patient->appointments as $appointment)
                                <tbody>
                                <tr>
                                    <td class="text-left">{{$appointment->id}}</td>
                                    <td>{{$appointment->doctor->name}}</td>
                                    <td class="text-left">{{$appointment->date}}</td>
                                    <td class="text-left">
                                        @if($appointment->prescription)
                                            <a href='{{url('/prescriptions/'.$appointment->prescription->id.'/print')}}' target="popup" onclick="window.open('{{url('prescriptions/'.$appointment->prescription->id.'/print')}}','popup','width=1300,height=700,location=0,scrollbars=no,resizable=no'); return false;">View Prescription</a>
                                        @else
                                            Prescription Not Found.
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- column -->
        <div class="col-md-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Patient Details</h4>
                        <a class='float-right' href="{{route('patients.edit',$patient->id)}}"><i class="ti-pencil-alt"></i></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">Name</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->name}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Species</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->species ? $patient->species->name : ''}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Gender</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->gender}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Age</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->age ? $patient->age->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days'):''}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Breed</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->breed}}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Color</td>
                                <td>:</td>
                                <td class="text-left">{{$patient->color}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="float-left">Invoices</h4>
                        <a class='float-right' href="{{route('bills.create','patid='.$patient->id)}}"><b><i class="ti-plus"></i></b></a>
                    </div>
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Net Amount</th>
                                <th>Discount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            @foreach($patient->bills as $bill)
                                <tbody>
                                <tr>
                                    <td class="text-left">{{$bill->id}}</td>
                                    <td>{{$bill->date}}</td>
                                    <td class="text-left">{{$bill->nettotal}}</td>
                                    <td class="text-left">{{$bill->discount}}</td>
                                    <td class="text-left"><a href="{{url('/bills/'.$bill->id.'/print')}}" target="popup" onclick="window.open('{{url('bills/'.$bill->id.'/print')}}','popup','width=1300,height=700,location=0,scrollbars=no,resizable=no'); return false;">View Invoice</a></td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"></div>
@endsection
@section('scripts')
    <script>
        $(document).on('click','#help', function () {
            var hello = $('.datelp').val();
            console.log(hello);
        });
    </script>
@endsection