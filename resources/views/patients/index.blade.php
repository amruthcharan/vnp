@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Patients</title>
@endsection

@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Patients</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Patients</li>
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
                        <h4 class="float-left">Patients List</h4>
                        <a class='btn btn-primary btn-sm float-right' href="{{route('patients.create')}}"><i class="ti-plus"></i><strong> New</strong></a>
                    </div>

                    <div class="table-responsive">
                        <table id="owners" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Species</th>
                                <th>Age</th>
                                <th>Color</th>
                                <th>Breed</th>
                                <th>Owner Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($patients))
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{$patient->id}}</td>
                                        <td>{{$patient->name}}</td>
                                        <td>{{$patient->species ? $patient->species->name : ""}}</td>
                                        <td>{{$patient->age->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days')}}</td>
                                        <td>{{$patient->color}}</td>
                                        <td>{{$patient->breed}}</td>
                                        <td>{{$patient->ownername}}</td>
                                        <td>
                                            <a class="btn btn-dribbble" href="{{route('patients.edit', $patient->id)}}">Edit</a>
                                            <a class="btn btn-info" href="{{route('patients.show', $patient->id)}}">Patient Info</a>
                                            <a class="btn btn-success" href="{{'/bills/create?patid='.$patient->id}}">Invoice</a>
                                            {{--<a href="javascript:void(0)" data-toggle="modal" data-target="#delete-user" class="btn btn-info waves-effect waves-light">Delete</a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#owners').DataTable();

        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type') }}";

        switch(type){
            case 'info':
                toastr.info("{{session('message')}}", "{{session('head')}}");
                break;
            case 'success':
                toastr.success("{{session('message')}}", "{{session('head')}}");
                break;
            case 'danger':
                toastr.error("{{session('message')}}", "{{session('head')}}");
                break;
            case 'warning':
                toastr.warning("{{session('message')}}", "{{session('head')}}");
                break;
        }
        @endif
    </script>
@endsection