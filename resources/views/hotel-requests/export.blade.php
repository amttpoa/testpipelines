<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Staff</th>
            <th>Conference Instructor</th>
            <th>Romm Type</th>
            <th>Roommate</th>
            <th>Room</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conference->conferenceHotelRequests as $request)
        <tr>
            <td>{{ $request->user->name }}</td>
            <td>
                {{ $request->user->hasRole('Staff') ? 'Staff' : '' }}
                {{ $request->user->hasRole('VIP') ? 'VIP' : '' }}
            </td>
            <td>{{ $request->user->hasRole('Conference Instructor') ? 'Conference Instructor' : '' }}</td>
            <td>{{ $request->room_type }}</td>
            <td>{{ $request->roommate }}</td>
            <td>{{ $request->room }}</td>
            <td>{{ $request->start_date ? $request->start_date->format('m/d/Y') : '' }}</td>
            <td>{{ $request->end_date ? $request->end_date->format('m/d/Y') : '' }}</td>
            <td>{{ $request->comments }}</td>
        </tr>
        @endforeach
    </tbody>
</table>