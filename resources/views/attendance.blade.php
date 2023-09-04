<!-- <table>
    <tr>
        <th>User ID</th>
    </tr>
    @foreach($attendance as $user)
        <tr>
            <td>{{ $user->userId }}</td>
        </tr>
    @endforeach
</table> -->

<table> <tr> <th>User ID</th> </tr> @foreach($attendance as $user) <tr> <td>{{ $user->attandanceId }}</td> </tr> @endforeach </table>
