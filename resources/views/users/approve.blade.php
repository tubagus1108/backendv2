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
<h3>Approve</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Approve</li>
@endsection
@section('content')
<div class="container-fluid">
    <h3>{{$data->first_name}} {{$data->last_name}}</h3>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>DETAIL USER</h5>
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
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Name:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->first_name}} {{$data->last_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Gender:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->gender}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Email:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->email}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Phone Number:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->user_hp}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">ID Card Type:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->id_card_type}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">ID Card Number:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->id_card_num}}/p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Place of Birth:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->place_birth}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Date of Birth:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->date_birth_carbon}} </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Address:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->address}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Country of Residence:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            @if ($data->country_residence == null)
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">n/a</p>
                            @else
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->country_residence}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Nationality:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->country_relation->negara}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Province:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->province_relation->nama_province}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">City:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->city_relation->nama_city_bi}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Occupation:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            @if ($data->occupation == null)
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">n/a</p>
                            @else
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->occupation}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">ZIP Code:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->zip}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Account Created:</p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->created_at}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Admin:</p>
                        </div>
                        @if ($data->approve_1 == null)
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">Pending</p>
                        </div>
                        @else
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->approve_1}}</p>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Admin By:</p>
                        </div>
                        @if($data->admin_relation == null)
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal"> - </p>
                        </div>
                        @else
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->admin_relation->approve_admin_name}}</p>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Admin Date:</p>
                        </div>
                        @if($data->approvedate_1 == null)
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal"> - </p>
                        </div>
                        @else
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->approvedate_1}}</p>
                        </div>
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Superadmin:</p>
                        </div>
                        @if ($data->approve_2 == null)
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">Pending</p>
                        </div> 
                        @else
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->approve_2}}</p>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Superadmin By:</p>
                        </div>
                        @if ($data->superadmin_relation == null)
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal"> - </p>
                        </div>
                        @else
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->superadmin_relation->approve_super_admin_name}}</p>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <p style="font-size: 1rem" class="text-left font-weight-bold">Approve Superadmin Date:</p>
                        </div>
                        @if ($data->approvedate_2 == null)
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal"> - </p>
                        </div>                  
                        @else
                        <div class="col-lg-6 mt-2">
                            <p  style="font-size: 1rem" class="text-right font-weight-normal">{{$data->approvedate_2}}</p>
                        </div>                  
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>ID CARD</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <p style="font-size: 1rem" class="font-weight-bold">ID CARD PHOTO:</p>
                        </div>
                    </div>
                    <div class="row mb-2" id="gallery" data-toggle="modal" data-target="#exampleModal">
                        <div class="col-lg-12">
                            @if($data->foto_id_card == null)
                            <img class="w-100 h-60" src="https://bitsofco.de/content/images/2018/12/broken-1.png" alt="First slide" data-target="#carouselExample" data-slide-to="0">
                            @else
                            <img class="w-100 h-70" src="{{$data->foto_id_card}}" alt="First slide" data-target="#carouselExample" data-slide-to="0">
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <p style="font-size: 1rem" class="font-weight-bold">SELFI WITH ID CARD:</p>
                        </div>
                    </div>
                    <div class="row" id="gallery" data-toggle="modal" data-target="#exampleModal">
                        <div class="col-lg-12">
                            @if($data->foto_selfie_id_card == null)
                            <img class="w-100 h-60" src="https://bitsofco.de/content/images/2018/12/broken-1.png" alt="First slide" data-target="#carouselExample" data-slide-to="0">
                            @else
                            <img class="w-100 h-70" src="{{$data->foto_selfie_id_card}}" alt="First slide" data-target="#carouselExample" data-slide-to="0">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <form method="POST" action="{{url('users/approve/'.$data['id'].'')}}">@csrf
                                <div class="row">
                                    <input type="radio" class="btn-check" name="approve" id="option1" value="Reject" autocomplete="off">
                                    <label class="btn btn-danger" for="option1">Reject</label>
                                    <input type="radio" class="btn-check" name="approve" id="option2" value="Approve" autocomplete="off">
                                    <label class="btn btn-primary" for="option2">Approve</label>
                                </div>
                                <div class="row">
                                    <button class="btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@endsection