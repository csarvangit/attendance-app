<table>
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Role</th>
    </tr>
    @foreach($attendance as $user)
        <tr>
            <td>{{ $user->userId }}</td>
            <!-- <td>{{ $user->firstName }}</td>
            <td>{{ $user->lastName }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->role }}</td> -->
        </tr>
    @endforeach
</table>
