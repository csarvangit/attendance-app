@extends('layouts.base')

@section('content') 
<h3>Users List</h3>
<table class="table">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Shift Time</th>
        <!--<th>Punch In Time</th>
        <th>Punch Out Time</th> -->
        <th>Current Day Photo</th>
        <th>Action</th>
    </tr>
    @if( !$users->isEmpty() )
        @foreach($users as $user)
            <tr>
                <td>{{ $user->userId }}</td>
                <td>{{ $user->firstName }} {{ $user->lastName }}</td>               
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->shiftName }}</td>
                <!-- <td>{{ $user->startTime ? $user->startTime : '-' }}</td>
                <td>{{ $user->endTime ? $user->endTime : '-' }}</td> -->
                <td>
                @if( file_exists(public_path('/uploads/staffs/'.$user->imageUrl)))
                @php $img = URL::to('/public/uploads/staffs/'.$user->imageUrl ); @endphp
                @else
                @php $img = URL::to('/public/uploads/thumb/user-thumb.png'); @endphp
                @endif
                <img src="{{ $img  }}" width="48" height="48">
                </td>
                <td><a class="btn btn-info btn-sm" href="{{route('userlog', $user->userId)}}" target="_blank">View Log</a></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">No Records Found</td>           
        </tr>
    @endif
</table>

<div class="pagination-nav flex items-center justify-between">     
    {{ $users->links() }} 
</div>
@endsection
