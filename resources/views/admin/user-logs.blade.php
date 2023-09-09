@extends('layouts.base')

@section('content') 

@if( !$attendancelogs->isEmpty() )
    <h3>{{ $attendancelogs[0]->firstName }} {{ $attendancelogs[0]->lastName }} Attendance Logs</h3> 
@endif            

<div class="container d-flex text-right justify-content-end my-2">

<div class="form-group col-lg-5">

    <div class='input-group'>
    <button type="button" class="btn btn-success mx-3" disabled>Download Report</button>
    <input type='text' class="form-control date" id='userLogDatePicker' />
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
    </span>
    </div>
</div>
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
                @if( file_exists(public_path('/uploads/staffs/'.$attendancelog->imageUrl)))
                @php $img = URL::to('/public/uploads/staffs/'.$attendancelog->imageUrl ); @endphp
                @else
                @php $img = URL::to('/public/uploads/thumb/user-thumb.png'); @endphp
                @endif
                <img src="{{ $img  }}" width="48" height="48">
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
            <td colspan="10" class="text-center">No Records Found</td>           
        </tr>
    @endif
</table>

<div class="pagination-nav flex items-center justify-between">        
	{{ $attendancelogs->links() }} 
</div>

@endsection

