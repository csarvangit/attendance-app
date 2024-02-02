<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vasantham Siru Semippu Thittam') }}</title>

    <!--favicon-->
	<link rel="icon" href="{{asset('/resources/assets_chitfund/images/favicon-32x32.png')}}" type="image/png" />
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{asset('/resources/assets_chitfund/css/app.css')}}">    
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<!--Data Tables -->
	<link href="{{asset('/resources/assets_chitfund/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('/resources/assets_chitfund/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">	
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('/resources/assets_chitfund/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto&display=swap" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="{{asset('/resources/assets_chitfund/css/icons.css')}}" />
	<!-- App CSS -->
	<link rel="stylesheet" href="{{asset('/resources/assets_chitfund/css/app.css')}}" />
	<link rel="stylesheet" href="{{asset('/resources/assets_chitfund/css/dark-sidebar.css')}}" />
	<link rel="stylesheet" href="{{asset('/resources/assets_chitfund/css/dark-theme.css')}}" />
</head>
<body>
@php 
use App\Http\Controllers\ChitFund\ChitFundController;
use Carbon\Carbon; 
@endphp

@if( !$user->isEmpty() )
	@php
		$plan_name  = $user[0]->plan_name;
		$plan_amount  = $user[0]->plan_amount;
		$billId    = $user[0]->due_id;
		$user_name = $user[0]->user_name;
		$mobile_no = $user[0]->mobile_no;
		$due_date = $user[0]->due_date;
		$due_date_paid = $user[0]->due_date_paid != null ? Carbon::parse($user[0]->due_date_paid)->format('d-m-Y') : '-' ;
		$status_code = $user[0]->due_status;
		$status = ChitFundController::getDueStatus($status_code, $key='string');
		$amount_paid = $status_code == 1 ? $plan_amount : 0;
	@endphp
@endif

<style>
/* Print */
.centered {
	text-align: center;
	align-content: center;
}

.printInvoice {
	width: 375px;
	max-width: 375px;
	margin: 0 auto;
}

.printInvoice td,
.printInvoice th,
.printInvoice tr,
.printInvoice table {
	border-top: 1px solid black;
	border-collapse: collapse;
}
.token {
	font-size: 38px;
	line-height: 46px;
}
.pace-activity {
	display: none;	
}
</style>
<!-- print block -->			
<div id="printInvoice" class="printInvoice">
	<div class="print-header-wrapper centered">
		<img src="{{asset('/resources/assets_chitfund/images/logo-icon-1.png')}}" style="height: 100px;"  alt="">
		<p class="centered fw-normal mt-3">Iyer Bungalow | Alanganallur | Palamedu | Valasai</p> 
		<p class="centered fw-normal mt-2">Contact: 99943 33605</p> 
		<p class="centered fw-bold mt-2">VASANTHAM SIRU SEMIPPU THITTAM</p>
		<p class="centered fw-bold mt-2">Token Number</p>
		<p class="centered fw-bold mt-2 token">#{{ $user[0]->user_id }}</p>
			
		<p class="centered  mt-2">Invoice No: <span class="invoice-no"> #{{$billId}}</span></p>
		<p class="centered  mt-2">Date: <span class="invoice-date">{{ Carbon::now()->format('Y-m-d H:i:s') }}</span></p>
	</div>	
	
	
	<table class="  mt-2 " style="width:100%">
		<!-- <thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
			</tr>
		</thead> -->
		<tbody>
			<tr>
				<td>User Name</td>
				<td>{{ $user_name }}</td>							
			</tr>
			<tr>
				<td>Plan Name</td>
				<td>{{ $plan_name }}</td>							
			</tr>
			<tr>
				<td>Plan Amount</td>
				<td>{{ $plan_amount }}</td>							
			</tr>
			<tr>
				<td>Status</td>
				<td>{{ $status }}</td>							
			</tr>
			<tr>
				<td>Amount Paid</td>
				<td>Rs {{ $amount_paid }}</td>						
			</tr>
			<tr>
				<td>Amount Paid Date</td>
				<td>{{ $due_date_paid }}</td>						
			</tr>
		</tbody>
	</table>
	<table class="  mt-2 " style="width:100%">
		<thead>
			<tr>
				<th class="">Total Amount Paid</th>
				<th class="price">Rs: {{ $amount_paid }}</th>
			</tr>
		</thead>
		
	</table>
	<p class="centered mt-3">Thank You!
	<br>Vasantham Group Of Companies</p>
</div>
<!-- end print -->	

<script src="{{asset('/resources/assets_chitfund/js/jquery.min.js')}}"></script>
<script type="text/javascript">
	(function($) {
		setTimeout(function(){ 
			window.print(); 
			//document.execCommand('print');
			window.close();
		}, 500);
	})(jQuery);
</script>
</body>
</html>

