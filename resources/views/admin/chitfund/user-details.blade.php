@extends('layouts.chitfund.base')

@section('content') 

@php 
use App\Http\Controllers\ChitFund\ChitFundController;
use Carbon\Carbon; 

@endphp

<!--page-content-wrapper-->
	<div class="page-content-wrapper mt-5">
		<div class="page-content">					
			
			<div class="card">
						<div class="card-body">
							<div class="card-title">
								@if( !$user->isEmpty() )
									<a href="{{route('chitfund.showPlan', $user[0]->plan_id)}}"><i class="lni lni-arrow-left-circle" style="font-size: 30px; float: right;"></i></a>								
								
									<h4 class="mb-0">{{ $user[0]->user_id }} -  {{ $user[0]->user_name }} </h4>
								@endif 	
							</div>
							<hr/>
							<div class="table-responsive">					
								<table id="example2" class="table table-striped table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>SL.No</th>
											<th>Month</th>
											<th>Plan</th>
											<th>Status</th>
											<th>Print</th>
										</tr>
									</thead>
									<tbody>
										@if( !$user->isEmpty() )
											@php
												$i = 0;
										    @endphp 
											@foreach($user as $u)
												@php
													$i = $i+1;
												@endphp 
												<tr>
													<td>{{ $i }}</td>
													<td>{{ Carbon::parse($u->due_date_paid)->format('M Y') }}</td>
													<td>
														<a href="javascript:;" class="btn btn-sm btn-light-{{ $u->due_status == 1 ? 'success' : 'warning' }} btn-block radius-30">
														{{ ChitFundController::getDueStatus($u->due_status, $key='string') }}
													</a>
													</td>
													<td>
														<select class="single-select select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
															<option value="0" data-select2-id="3">Un Paid</option>
															<option value="1" data-select2-id="35">Paid</option>
															<option value="2" data-select2-id="35">Closed</option>
														</select>
													</td>
													<td>
														<a href=""> <i class="lni lni-printer" style="font-size: 18px;"></i> </a>
														&nbsp;
														<a href=""><i class="lni lni-whatsapp" style="font-size: 18px;"></i></a>
													</td>
													
												</tr>
											@endforeach
										@else
										<tr>
											<td colspan="5" class="text-center">No Dues Paid</td>
										<tr>
									@endif	
								
									</tbody>
									<tfoot>
										<tr>
											<th>SL.No</th>
											<th>Month</th>
											<th>Plan</th>
											<th>Status</th>
											<th>Print</th>
										</tr>
									</tfoot>
								</table>
							</div>
							
						</div>
						
					</div>
					<!--end card-->			
			
			
			<!-- Return Response Popup Model -->
			<div class="modal fade" id="ResponseMsgModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">						
						<div class="modal-body">
							@if($errors->any())
								<div class="alert alert-danger alert-dismissible" role="alert">
									@foreach($errors->all() as $error)
										{{ $error }} <br/>
									@endforeach
								</div>
							@endif

							@if(session()->has('success'))
								<div class="alert alert-success alert-dismissible" role="alert">
									{{ session()->get('success') }}
								</div>
							@endif					
																	
						</div>	
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						</div>						
					</div>					
				</div>
			</div>	
			<!-- End of Return Response Popup Model -->			
			
		</div>
	</div>
	<!--end page-content-wrapper-->
@endsection
