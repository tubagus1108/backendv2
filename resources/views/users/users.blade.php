@extends('layouts.simple.master')
@section('title', 'Users')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/daterange-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Users</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Users</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<!-- Individual column searching (text inputs) Starts-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="col-lg-5">
						<div class="theme-form">
							<div class="form-group">
								<input class="form-control digits" type="text" name="daterange" value="01/15/2021 - 02/15/2021">
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="display" id="data-users">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Type</th>
									<th>Status BI</th>
									<th>Email</th>
									<th>KTP</th>
									<th>Status Admin</th>
									<th>Admin Approve</th>
									<th>Status</th>
									<th>Action</th>
									{{-- <th>Recipient</th> --}}
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Individual column searching (text inputs) Ends-->
	</div>
</div>
@endsection

@section('script')
<script>
	$(function(){
		$('#data-users').DataTable({
			ajax: '{{route('datatable-users')}}',
			columns: [
				{ data: 'id', name: 'id' },
				{ data: 'name', name: 'name'},
				{ data: 'type', name: 'type'},
				{ data: 'status_bi_check', name: 'status_bi_check'},
				{ data: 'email', name: 'email'},
				{ data: 'id_card_num', name: 'id_card_num'},
				{ data: 'approve_1', name: 'approve_1'},
				{ data: 'admin', name: 'admin'},
				{ data: 'user_status', name: 'user_status'},
				{ data: 'action', name: 'action'},
			],
		})
	})
</script>
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/moment.min.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js')}}"></script>
@endsection