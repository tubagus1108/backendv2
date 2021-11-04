@extends('layouts.simple.master')
@section('title', 'Approve User')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/daterange-picker.css')}}">
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
    <p>User ID : {{$data->id}}</p>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail User</h5>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                
                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    
@endsection