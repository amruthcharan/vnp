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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reminders as $rem)
                            @if($rem->prescription == null)
                                <tr>
                                    <td>{{$rem->id}}</td>
                                    <td>{{$rem->patient->name}}</td>
                                    <td>{{$rem->patient->ownername}}</td>
                                    <td>{{$rem->patient->mobile}}</td>
                                    <td>{{$rem->patient->email ? $rem->patient->email : ""}}</td>
                                    <td>{{date('d-m-Y', strtotime($rem->date))}}</td>
                                    <td><button class="btn btn-danger sendsms">Send SMS</button></td>
                                </tr>
                            @endif
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
        $('#zero_config').DataTable({"order": [5,'asc']});

        $('table').delegate('.sendsms','click', function(){
            var aid = $(this).closest('tr').find('td').eq(0).html();
            $(document).ajaxStart(function(){
                $(".preloader").show();
            }).ajaxStop(function(){
                $(".preloader").fadeOut();
            });
            $.ajax({
                url : "/sendsms/"+aid,
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