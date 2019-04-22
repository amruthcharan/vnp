@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Update Patient</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Patient Details</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Owners</li>
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
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['PatientController@update',$patient->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('ownername', 'Owner Name:') !!}
                        {!! Form::text('ownername', $patient->ownername, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', 'Address:') !!}
                        {!! Form::textarea('address', $patient->address, ['class'=>'form-control', 'rows' => 5, 'cols' => 40]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mobile', 'Mobile Number:') !!}
                        {!! Form::text('mobile', $patient->mobile, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email Address:') !!}
                        {!! Form::text('email', $patient->email, ['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', $patient->name, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('species_id', 'Species:') !!}
                        {!! Form::select('species_id', $species ,$patient->species, ['class'=>'form-control select32']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('age', 'Age:') !!}
                        {!! Form::date('age', $patient->age, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('color', 'Color:') !!}
                        {!! Form::text('color', $patient->color, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('breed', 'Breed:') !!}
                        {!! Form::text('breed', $patient->breed, ['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="border-top">
                <div class="card-body">
                    {!! Form::submit('Update Patient', ['class'=>'btn btn-primary btn-block']) !!}
                </div>
            </div>
            {!! Form::close() !!}
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