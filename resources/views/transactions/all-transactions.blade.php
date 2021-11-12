@extends('layouts.simple.master')
@section('title', 'Approve User')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/daterange-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>User Transaction</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">List User Transaction</li>
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<!-- Individual column searching (text inputs) Starts-->
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				</div>
				<div class="card-body">
					<div class="table-responsive">
						@if (Auth::user()->type_user == 3)
						<table class="display" id="data-superadmin">
							<thead>
								<tr>
									<th>Transaction Number</th>
									<th>Invoice Number</th>
									<th>Transaction Date</th>
									<th>Sender Name</th>
									<th>Recipient Name</th>
									<th>Destination Rate</th>
                                    <th>Destination Country</th>
									<th>Fee</th>
									<th>Total Send</th>
									<th>Voucher</th>
									<th>Total Pay</th>
									<th>Acc Number</th>
									<th>Status by Admin</th>
									<th>Admin Approve</th>
									<th>Status by Superadmin</th>
                                    <th>Status Transaction</th>
                                    {{-- <th>Actions</th> --}}
								</tr>
							</thead>
						</table>
						@else
						<table class="display" id="data-admin">
							<thead>
								<tr>
									<th>Transaction Number</th>
									<th>Invoice Number</th>
									<th>Transaction Date</th>
									<th>Sender Name</th>
									<th>Recipient Name</th>
									<th>Destination Rate</th>
									<th>Destination Country</th>
									<th>Fee</th>
									<th>Total Send</th>
									<th>Voucher</th>
									<th>Total Pay</th>
									<th>Status Transaction</th>
									<th>Actions</th>
								</tr>
							</thead>
						</table>
						@endif
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
		$('#data-admin').DataTable({
			ajax: '{{route('admin-transactions-datatable')}}',
			columns:[
				{data: 'id',name:'id'},
				{data: 'invoice_num',name:'invoice_num'},
				{data: 'datetransaction',name:'datetransaction'},
				{data: 'sender',name:'sender'},
				{data: 'recipient',name:'recipient'},
				{data: 'rate',name:'rate'},
				{data: 'country',name:'country'},
				{data: 'fee',name:'fee'},
				{data: 'totalsend',name:'totalsend'},
				{data: 'voucher',name:'voucher'},
				{data: 'totalpay',name:'totalpay'},
				{data: 'status_trx',name:'status_trx'},
				{data: 'actions',name:'actions'},
			],
		})
		$('#data-superadmin').DataTable({
			ajax: '{{route('transaction-superadmin-datatable')}}',
			columns:[
				{data: 'id',name:'id'},
				{data: 'datetransaction',name:'datetransaction'},
				{data: 'sender',name:'sender'},
				{data: 'recipient',name:'recipient'},
				{data: 'acc_number',name:'acc_number'},
				{data: 'bank_name',name:'bank_name'},
				{data: 'totalsend',name:'totalsend'},
				{data: 'rate',name:'rate'},
				{data: 'fee',name:'fee'},
				{data: 'voucher',name:'voucher'},
				{data: 'totalpay',name:'totalpay'},
				{data: 'service',name:'service'},
				{data: 'adminapprove',name:'adminapprove'},
				{data: 'statusapprove',name:'statusapprove'},
				{data: 'approveButton',name:'approveButton'},
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