@extends('layouts.simple.master')
@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Dashboard {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-sm-12">
			<a href="{{route('index-users')}}">
				<div class="card o-hidden">
					<div class="card-body">
						<div class="ecommerce-widgets media">
							<div class="media-body">
							<p style="font-size: 20px" class="f-w-500 font-roboto">Total Users</p>
							<h4 class="f-w-500 mb-0 f-26"><span class="counter">{{$users}}</span></h4>
							</div>
							<div class="ecommerce-box light-bg-primary"><i class="mdi mdi-account-multiple-check"></i></div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-lg-6 col-sm-12">
			<a href="{{route('transactions-success')}}">
				<div class="card o-hidden">
					<div class="card-body">
						<div class="ecommerce-widgets media">
							<div class="media-body">
							<p style="font-size: 20px" class="f-w-500 font-roboto">Success Transactions</p>
							<h4 class="f-w-500 mb-0 f-26"><span class="counter">{{$success_transactions}}</span></h4>
							</div>
							<div class="ecommerce-box light-bg-primary"><i class="mdi mdi-format-list-checks"></i></div>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3 col-sm-12">
			<a href="{{route('pending-users')}}">
				<div class="card o-hidden">
					<div class="card-body">
						<div class="ecommerce-widgets media">
							<div class="media-body">
							<p style="font-size: 18px" class="f-w-500 font-roboto">Pending Register</p>
							<h4 class="f-w-500 mb-0 f-26"><span class="counter">{{$pending_register}}</span></h4>
							</div>
							<div class="ecommerce-box light-bg-primary"><i class="mdi mdi-account-clock"></i></div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-lg-3 col-sm-12">
			<a href="{{route('transactions-pending')}}">
				<div class="card o-hidden">
					<div class="card-body">
						<div class="ecommerce-widgets media">
							<div class="media-body">
							<p style="font-size: 18px" class="f-w-500 font-roboto">Pending Transactions</p>
							<h4 class="f-w-500 mb-0 f-26"><span class="counter">{{$pending_transactions}}</span></h4>
							</div>
							<div class="ecommerce-box light-bg-primary"><i class="mdi mdi-cart-arrow-up"></i></div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-lg-3 col-sm-12">
			<a href="">
				<div class="card o-hidden">
					<div class="card-body">
						<div class="ecommerce-widgets media">
							<div class="media-body">
							<p style="font-size: 18px" class="f-w-500 font-roboto">Pending Vendor Orders</p>
							<h4 class="f-w-500 mb-0 f-26"><span class="counter">{{$pending_vendor}}</span></h4>
							</div>
							<div class="ecommerce-box light-bg-primary"><i class="mdi mdi-cart-arrow-down"></i></div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-lg-3 col-sm-12">
			<a href="">
				<div class="card o-hidden">
					<div class="card-body">
						<div class="ecommerce-widgets media">
							<div class="media-body">
							<p style="font-size: 18px" class="f-w-500 font-roboto">Processing Vendor Order</p>
							<h4 class="f-w-500 mb-0 f-26"><span class="counter">0</span></h4>
							</div>
							<div class="ecommerce-box light-bg-primary"><i class="mdi mdi-cart-arrow-right"></i></div>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{asset('assets/js/chart/knob/knob.min.js')}}"></script>
<script src="{{asset('assets/js/chart/knob/knob-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets/js/dashboard/default.js')}}"></script>
<script src="{{asset('assets/js/notify/index.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
@endsection

