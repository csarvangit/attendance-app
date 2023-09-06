@extends('layouts.base')

@section('content') 
<h3>Log Entry List</h3>
<table class="table">
    <tr>
        <th>SL No</th>
        <th>Attendance ID</th>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Punch In Time</th>
        <th>Punch Out Time</th>
        <th>Punch In Date</th>
        <th>Punch Out Date</th>
    </tr>

    @if( !$attendancelogs->isEmpty() )

        @foreach($attendancelogs as $key => $attendancelog)
            <tr>
                <td>{{ $attendancelogs->firstItem() + $key}}</td>
                <td>{{ $attendancelog->attandanceId }}</td>
                <td>{{ $attendancelog->userId }}</td>
                <td>{{ $attendancelog->firstName }}</td>
                <td>{{ $attendancelog->lastName }}</td>
                <td>{{ $attendancelog->startTime }}</td>
                <td>{{ $attendancelog->endTime }}</td>
                <td>{{ $attendancelog->startDate }}</td>
                <td>{{ $attendancelog->endDate }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="9" class="text-center">No Records Found</td>           
        </tr>
    @endif
</table>

<div class="pagination-nav flex items-center justify-between">        
	{{ $attendancelogs->links() }} 
</div>

@endsection

