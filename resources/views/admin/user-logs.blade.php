@extends('layouts.base')

@section('content') 

@if ($errors->any())
    <div class="alert alert-danger  alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if( !$attendancelogs->isEmpty() )
    <h3>{{ $attendancelogs[0]->firstName }} {{ $attendancelogs[0]->lastName }} Attendance Logs</h3> 
@endif   

<div class="container d-flex text-right justify-content-end my-2">
    @if( !$attendancelogs->isEmpty() )
    <div class="col-lg-3">
    <form action="{{ route('attendancelogs.export') }}" method="post">
        @csrf
        <div class="form-group">
            <div class='input-group text-right justify-content-end flex'>
            <input type='hidden' name="id" value="{{$attendancelogs[0]->userId}}" />
                {{----}}
                 <input type='text' name="date" class="form-control date  mx-2" id='userLogDatePicker' />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>                
                <button class=" mt-8 text-center btn btn-success py-2">Download Report</button>
            </div>
        </div>         
        </form>    
        </div>    
    @endif
</div>



<table class="table">
    <tr>
        <th>SL No</th>
        <th>User</th>        
        <th>Shift Time</th>
        <th>Punch In Time</th>
        <th>Punch Out Time</th> 
        <th>Punch In Date</th>
        <th>Punch Out Date</th>
        <th>Total Hours</th>        
        <th>Permission</th>
        <th>Leave</th>
        <th>Late</th>
        <th>OverTime</th>
    </tr>

    @if( !$attendancelogs->isEmpty() )

        @foreach($attendancelogs as $key => $attendancelog)
            <tr>
                <td>{{ $attendancelogs->firstItem() + $key}}</td>
                <td>
                    @if( $attendancelog->imageUrl != '' && file_exists(public_path('/uploads/staffs/'.$attendancelog->imageUrl)) )
                        @php $img_src = URL::to('/public/uploads/staffs/'.$attendancelog->imageUrl ); @endphp
                    @else
                        @php $img_src = URL::to('/public/uploads/thumb/user-thumb.png'); @endphp
                    @endif             
                    <a href="{{ $img_src }}" data-toggle="lightbox" data-caption="{{ $attendancelog->firstName }} {{ $attendancelog->lastName }}" data-size="sm" data-constrain="true" class="col-sm-4" data-gallery="User Thumb">
                        <img class="img-fluid" src="{{ $img_src }}" width="48" height="48" />
                    </a>
                </td>    
                <td>{{ $attendancelog->shiftName }}</td>            
                <td>{{ $attendancelog->startTime ? $attendancelog->startTime : '-' }}</td>
                <td>{{ $attendancelog->endTime ? $attendancelog->endTime : '-' }}</td>
                <td>{{ $attendancelog->startDate }}</td>
                <td>{{ $attendancelog->endDate }}</td>
                <td>{{ $attendancelog->total_hours }}</td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="12" class="text-center">No Records Found</td>           
        </tr>
    @endif
</table>

<div class="pagination-nav flex items-center justify-between">        
	{{ $attendancelogs->links() }} 
</div>

@endsection

