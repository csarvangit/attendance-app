@extends('layouts.base')

@section('content') 
<h3>Users List</h3>
<table class="table">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    @if( !$users->isEmpty() )
        @foreach($users as $user)
            <tr>
                <td>{{ $user->userId }}</td>
                <td>{{ $user->firstName }} {{ $user->lastName }}</td>               
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->role }}</td>

                <td><a class="btn btn-info btn-sm" href="{{route('userlog', $user->userId)}}">View Log</a></td>
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
