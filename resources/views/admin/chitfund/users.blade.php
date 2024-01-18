@extends('layouts.chitfund.base')

@section('content') 

@php 
use Carbon\Carbon; 
@endphp

<!--page-content-wrapper-->
	<div class="page-content-wrapper mt-5">
		<div class="page-content">					
			
			<div class="card">
				<div class="card-body">
					<div class="card-title">
						<a href="{{route('chitfundIndex')}}"><i class="lni lni-arrow-left-circle" style="font-size: 30px; float: right;"></i></a>
						@if( !$users->isEmpty() )							
							@php 
								$start_date = Carbon::parse($users[0]->start_date);
								$end_date = Carbon::parse($users[0]->end_date);
							@endphp
						
						<h4 class="mb-0">{{ $users[0]->plan_name }} ({{ $start_date->diffInMonths($end_date); }} Months Scheme) </h4>
						<h5>{{ Carbon::parse($users[0]->start_date)->format('M Y') }} To {{ Carbon::parse($users[0]->end_date)->format('M Y') }}</h5>
						@endif
					</div>
					<hr/>
					<div class="table-responsive">					
						<table id="example2" class="table table-striped table-bordered" style="width:100%">
							<div class="ms-auto">
								<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: inline-start;"><i class="lni lni-circle-plus"></i> Add User</button>
							</div>
							<thead>
								<tr>
									<th>User Id</th>
									<th>User Name</th>
									<th>Phone Number</th>
									<th>Address</th>
									<th>Due</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
								@if( !$users->isEmpty() )
									@if( isset($users[0]->user_id) && $users[0]->user_id != 'null' )
										@foreach($users as $user)
											<tr>
												<td>{{ $user->user_id }}</td>
												<td>{{ $user->user_name }}</td>
												<td>{{ $user->mobile_no }}</td>
												<td>{{ $user->address }}</td>
												<td><a href="javascript:;" class="btn btn-sm btn-light-success btn-block radius-30">Paid</a></td>
												<td>
													<a href="user-details.html"><i class="lni lni-eye" style="font-size: 18px; font-weight: 800;"></i></a>
													&nbsp;
													<a href="user-details.html"><i class="lni lni-pencil-alt" style="font-size: 18px; font-weight: 800;"></i></a>
													&nbsp;
													<a href="user-details.html"><i class="lni lni-checkmark" style="font-size: 18px; font-weight: 800;"></i></a>
												</td>
											</tr>
											
										@endforeach
									@else
										<tr>
											<td colspan="6" class="text-center">No Records Found</td>
										<tr>
									@endif							
								@endif
						
							</tbody>
							<tfoot>
								<tr>
									<th>User Id</th>
									<th>User Name</th>
									<th>Phone Number</th>
									<th>Address</th>
									<th>Due</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
					
				</div>
				
			</div>
			<!--end card-->
			
			<div class="col">
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" style="background-color:#673ab7;">
								<h5 class="modal-title" id="exampleModalLabel" style="color: aliceblue;">Add User</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<form class="formm" action="{{route('chitfund.createUser')}}" method="POST">
									@csrf		

									<input type="hidden" name="plan_id" value="{{ $users[0]->plan_id }}">	
										
									<label for="user_name" class="labell">Name</label>
									<div class="form-group {{ $errors->has('user_name') ? 'has-error' : ''}}">
										<input id="user_name" type="text" class="form-control inputt @error('user_name') is-invalid @enderror" name="user_name" placeholder="Enter Name" value="{{ old('user_name') }}" required />
										{!! $errors->first('user_name', '<p class="help-block">:message</p>') !!}
									</div>
							
									<label for="mobile_no" class="labell">Phone Number</label>
									<div class="form-group {{ $errors->has('mobile_no') ? 'has-error' : ''}}">
										<input id="mobile_no" type="tel" class="form-control inputt @error('mobile_no') is-invalid @enderror" name="mobile_no" placeholder="Enter Phone Number" value="{{ old('mobile_no') }}" pattern="[0-9]{10}" required />
										{!! $errors->first('mobile_no', '<p class="help-block">:message</p>') !!}
									</div>	
									
									<label for="address" class="labell">Address</label>
									<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
									
										<textarea id="address" type="tel" class="form-control inputt @error('address') is-invalid @enderror" name="address" placeholder="Enter Address" value="{{ old('address') }}"  required></textarea>
										{!! $errors->first('address', '<p class="help-block">:message</p>') !!}
									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Save changes</button>
									</div>
								</form>
								<style>
									
							
									.formm {
										
										padding: 20px;
										border-radius: 10px;
										width: 450px;
									}
							
									.labell {
										display: block;
										margin-bottom: 8px;
										font-weight: bold;
									}
							
									.inputt {
										width: 100%;
										padding: 8px;
										margin-bottom: 15px;
										box-sizing: border-box;
										border: 2px solid #673ab7;
										border-radius: 4px;
									}
							
							
									
								</style>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
			
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
