@extends('layouts.base')

@section('content') 

@if( !$attendancelogs->isEmpty() )
    <h3>{{ $attendancelogs[0]->firstName }} {{ $attendancelogs[0]->lastName }} Attendance Logs</h3> 
@endif   

<div class="container d-flex text-right justify-content-end my-2">
    @if( !$attendancelogs->isEmpty() )
        <div class="form-group col-lg-5">
            <div class='input-group text-right justify-content-end flex'>
                
                {{-- <input type='text' class="form-control date" id='userLogDatePicker' />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span> --}}
                <a href="{{ route('attendancelogs.export', $attendancelogs[0]->userId) }}" class="btn btn-success">Download Report</a>
            </div>
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
                    <a href="{{ $img_src }}" data-toggle="lightbox" data-caption="{{ $attendancelog->firstName }} {{ $attendancelog->lastName }}" data-size="sm" data-constrain="true" class="col-sm-4">
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

