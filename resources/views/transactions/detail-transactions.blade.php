@extends('layouts.simple.master')
@section('title', 'Approve User')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/daterange-picker.css')}}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Transaction</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Detail Transaction</li>
@endsection
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Transaction</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">ID:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->id}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Transaction Date:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->transaction_date_carbon}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Sender Name:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['users_relation']->first_name}} {{$data['users_relation']->last_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Recipient Name:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['receipt_relation']->first_name}} {{$data['receipt_relation']->last_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Destination Rate:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">1 {{$data['receipt_relation']->currency_to}} = {{$data['receipt_relation']->currency}} {{number_format($data['customer_rate'])}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Bank Recipient:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['receipt_relation']->bank_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Phone Number:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['receipt_relation']->phone_number}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Destination Country:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['receipt_relation']->country_to}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Total Send:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['receipt_relation']->currency_to}} {{$data['recipient_gets']}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Voucher:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            @if ($data['voucher_relation'] == null)
                                <p  style="font-size: 1rem" class="text-right font-weight-normal">0</p>
                            @else               
                                <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['voucher_relation']->code_voucher}}-({{$data['receipt_relation']->currency}}{{number_format($data['voucher_relation']->value)}})</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Total Pay:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['receipt_relation']->currency}} {{number_format($data['send'])}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Service:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['service']}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Bank Transfer:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['bank_relation']->bank_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Status Transaction:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['status_trx']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Approval Transaction</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Admin:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            @if ($data['status_approve_1'] == 1)
                                <p  style="font-size: 1rem" class="text-right font-weight-normal">Approved</p>
                            @else
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">Pending</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Admin Date:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['approve_admin_date_carbon']}}</p>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Superadmin:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            @if ($data['status_approve_2'] == 1)
                                <p  style="font-size: 1rem" class="text-right font-weight-normal">Approved</p>
                            @else
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">Pending</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve SuperAdmin Date:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data['approve_superadmin_date_carbon']}}</p>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <form action="">
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approval:</p>
                        </div>
                        <div class="col-lg-5">
                        @if ($data['status_approve_1'] == 1 && $data['status_approve_2'] == 1)
                            <input disabled type="radio" id="input" class="btn-check" name="approve" id="option1" value="Reject" autocomplete="off">
                            <label class="btn btn-danger" for="option1"><i class="fa fa-times"></i> Reject</label>
                            <input disabled type="radio" id="input" class="btn-check" name="approve" id="option2" value="Approve" autocomplete="off">
                            <label class="btn btn-success" for="option2"><i class="fa fa-check"></i> Approve</label>
                        @else
                            <input type="radio"class="btn-check input" name="approve" id="option1" value="Reject" autocomplete="off">
                            <label class="btn btn-danger" for="option1"><i class="fa fa-times"></i> Reject</label>
                            <input type="radio" class="btn-check input" name="approve" id="option2" value="Approve" autocomplete="off">
                            <label class="btn btn-success" for="option2"><i class="fa fa-check"></i> Approve</label>         
                        @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div>
                              <label style="font-size: 1rem" class="text-left font-weight-bold" class="form-label" for="exampleFormControlTextarea4">Remarks</label>
                              <textarea class="form-control" id="exampleFormControlTextarea4" rows="3"></textarea>
                            </div>
                          </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <a class="btn btn-outline-light" href="{{route('transactions-all')}}" role="button"><i class="fa fa-step-backward"></i> Back</a>
                            <button class="button btn btn-outline-primary">Sumbit</button>
                        </div>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    let input = document.querySelector("#option1");
    let input2 = document.querySelector("#option2");
    let button = document.querySelector("button");
    button.disabled = true;
    input.addEventListener("change", stateHandle);
    input2.addEventListener("change", stateHandle);
    function stateHandle() {
        if(document.querySelector(".input").value === "") {
            button.disabled = true;
        }else if(document.querySelector("#option2").value === ""){
            button.disabled = true;
        } else {
            button.disabled = false;
        }
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@endsection