@extends('layouts.main')
@section('title')
    <title>Vet N Pet - Billing</title>
@endsection
@section('breadcrum')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Invoice</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
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
                    <h4 class="card-title" style="text-align: center">New Invoice</h4>
                    @include('includes.formerror')
                    {!! Form::open(['method'=>'PATCH', 'action' => ['BillingController@update',$bill->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('patient_id', 'Patient ID:') !!}
                        {!! Form::select('patient_id', $patients , $bill->patient_id , ['class'=>'form-control', 'disabled'=>'disabled']) !!}
                    </div>
                    <div id="oomponent">
                        <h3 class="float-left">Components</h3>
                        <a onclick="addcomponent()" class="btn btn-primary float-right"><i class="fa fa-plus"></i></a>
                        <br>
                        <br>
                        @foreach($bill->billcomponents as $d)
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="component">Component:</label>
                                        <input type='text' name='component[]' value="{{$d->name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="amount">Amount:</label>
                                        <input type="number" name='amount[]' value="{{$d->amount}}" class="form-control bill billing">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class='btn btn-warning remove'>
                                        <i class='fa fa-minus'></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        {!! Form::label('discount', 'Discount:') !!}
                        {!! Form::text('discount',$bill->discount,['class'=>'form-control discount']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('total', 'Total:') !!}
                        {!! Form::text('total',$bill->total,['class'=>'form-control total', 'readonly'=>'readonly']) !!}
                    </div>
                    @php
                        $t=date('Y-m-d');
                    @endphp
                    <div class="form-group">
                        {!! Form::label('date', 'Date:') !!}
                        {!! Form::date('date', $bill->date, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            {!! Form::submit('Update Invoice', ['class'=>'btn btn-primary btn-block']) !!}
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
        var total = parseInt($(".total").val());;
        total = isZero(total);
        calcD();
        var dumpVal = 0;
        var currentValue= 0;
        function calcD() {
            var n = $('.discount').val().toString().search('%');
            //console.log(n);
            var discount = parseInt($(".discount").val());
            discount = isZero(discount);
            totalValue = total;
            if(n>0){
                var tot = totalValue + ((totalValue * discount)/100);
            } else {
                var tot = totalValue + discount;
            }
            //$('.total').val(tot);
            total = tot;
        }


        function addcomponent() {
            $('#oomponent').append("<div class=\"row align-items-center\"><div class=\"col-md-5\"><div class=\"form-group\"><label for=\"component\">Component:</label><input type='text' name='component[]' class=\"form-control\"></div></div><div class=\"col-md-5\"><div class=\"form-group\"><label for=\"amount\">Amount:</label><input type=\"number\" name='amount[]' class=\"form-control bill billing\"></div></div><div class=\"col-md-1\"><a class='btn btn-warning remove'><i class='fa fa-minus'></i></a></div></div>");
        }
        $(document).on('click', '.remove', function (){
            $(this).closest('.row').remove();
        });

        $(document).on('focus', '.billing', function () {
            $(this).addClass('biller');
            dumpVal = parseInt($(".biller").val());
            //console.log(dumpVal);
           dumpVal = isZero(dumpVal);
            $(this).removeClass('biller');
            //console.log(dumpVal);
        });
        $(document).on('change ', '.billing', function (){
            $(this).addClass('bill');
            currentValue = parseInt($(".bill").val());

            total -= dumpVal;
            total += currentValue;
            $(this).removeClass('bill');
            $('.total').val(total);
            calcDisc();
        });

        $(document).on('change', '.discount', calcDisc);
        function calcDisc() {
            var n = $('.discount').val().toString().search('%');
            //console.log(n);
            var discount = parseInt($(".discount").val());
            discount = isZero(discount);
            totalValue = total;
            if(n>0){
                var tot = totalValue - ((totalValue * discount)/100);
            } else {
                var tot = totalValue - discount;
            }
            $('.total').val(tot);
        }

        function isZero(val){
            var res = "";
            res = res + Number.isInteger(val);
            if (res == 'false'){
                val = 0;
            }
            return val;
            console.log(val);
        }
    </script>

@endsection