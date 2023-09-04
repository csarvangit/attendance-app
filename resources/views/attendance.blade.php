<table>
    <tr>
        <th>User ID</th>
    </tr>
    @foreach($attendance as $user)
        <tr>
            <td>{{ $user->userId }}</td>
        </tr>
    @endforeach
</table>
