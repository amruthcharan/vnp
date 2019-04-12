@extends('layouts.main')

@section('title')
    <title>Vet N Pet - Reminders</title>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reminders</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pet Name</th>
                            <th>Owner Name</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                            <th>Reminder Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reminders as $rem)
                            @php
                               $app = App\Appointment::find($rem->appointment_id);
                            @endphp
                            <tr>
                                <td>{{$app->id}}</td>
                                <td>{{$app->patient->name}}</td>
                                <td>{{$app->patient->owner->id}}</td>
                                <td>{{$app->patient->owner->mobile}}</td>
                                <td>{{$app->patient->owner->email ? $app->patient->owner->email : ""}}</td>
                                <td>{{$rem->reminder}}</td>
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
    </script>
@endsection