@php 
use Carbon\Carbon; 
$currentTime = Carbon::now();
@endphp
@extends('layouts.base')

@section('content') 


<div class="container d-flex  justify-content-between my-2"> 
    
        <div class='text-left justify-content-start flex'>                
                <h3>Users List</h3>
        </div>
        <div class='text-right justify-content-end flex'>                
             <span> {{ $currentTime->format('D') .' - '. $currentTime->format('d-M-Y'); }} </span>
        </div>
          
   
</div>

<table class="table">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Shift Time</th>
        <th>Punch In Time</th>
        <th>Punch Out Time</th> 
        <th>Current Day Photo</th>
        <th>Action</th>
    </tr>
    @if( !$users->isEmpty() )
        @foreach($users as $user)

        @php 
        $startTime = '-'; 
        $endTime = '-'; 
        $imageUrl = ''; 
        @endphp

        @if( !$attendance->isEmpty() )
             @foreach($attendance as $attend)
                @if( $attend->userId == $user->userId ) 
                    @php $startTime = $attend->startTime ? $attend->startTime : '-'; @endphp             
                    @php $endTime = $attend->endTime ? $attend->endTime : '-'; @endphp
                    @php $imageUrl = $attend->imageUrl ? $attend->imageUrl : ''; @endphp
                @endif
             @endforeach
        @endif
        

            <tr>
                <td>{{ $user->userId }}</td>
                <td>{{ $user->firstName }} {{ $user->lastName }}</td>               
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->shiftName }} </td>              
                <td>
                   {{--  @if(isset($user->startTime) && !empty($user->startTime)) 
                    {{ $user->startTime ? $user->startTime : '-' }}
                    @endif --}}

                    {{ $startTime }}
                </td>
                <td>
                {{-- @if(isset($user->endTime) && !empty($user->endTime)) 
                    {{ $user->endTime ? $user->endTime : '-' }}
                    @endif --}}

                    {{ $endTime }}
                </td>
                <td>
                {{-- @if(isset($user->imageUrl) && !empty($user->imageUrl)) 
                    @if( $user->imageUrl != '' && file_exists(public_path('/uploads/staffs/'.$user->imageUrl)) )
                        @php $img_src = URL::to('/public/uploads/staffs/'.$user->imageUrl ); @endphp
                    @else
                        @php $img_src = URL::to('/public/uploads/thumb/user-thumb.png'); @endphp
                    @endif    
                            
                    <a href="{{ $img_src }}" data-toggle="lightbox" data-caption="{{ $user->firstName }} {{ $user->lastName }}" data-size="sm" data-constrain="true" class="col-sm-4" data-gallery="User Thumb">
                        <img class="img-fluid" src="{{ $img_src }}" width="48" height="48" />
                    </a>
                @endif   --}}
                
                @if(isset($imageUrl) && !empty($imageUrl)) 
                    @if( $imageUrl != '' && file_exists(public_path('/uploads/staffs/'.$imageUrl)) )
                        @php $img_src = URL::to('/public/uploads/staffs/'.$imageUrl ); @endphp
                      
                        <a href="{{ $img_src }}" data-toggle="lightbox" data-caption="{{ $user->firstName }} {{ $user->lastName }}" data-size="sm" data-constrain="true" class="col-sm-4" data-gallery="User Thumb">
                            <img class="img-fluid" src="{{ $img_src }}" width="48" height="48" />
                        </a>
                    @endif 
                @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm my-1" href="{{route('userlog', $user->userId)}}" target="_blank">View Log</a>
                    @if( empty($user->shiftName) ) 
                    <a class="btn btn-info btn-sm my-1" href="{{route('shift.create', $user->userId)}}" target="_blank">Add Shift</a>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="9" class="text-center">No Records Found</td>           
        </tr>
    @endif
</table>

<div class="pagination-nav flex items-center justify-between">     
    {{ $users->links() }} 
</div>
@endsection
