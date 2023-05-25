<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Organization</th>
            <th>Organization 2</th>
            <th>Organization 3</th>
            <th>Registered</th>
        </tr>
    </thead>
    <tbody>
        @foreach($event->eventAttendees as $attendee)
        <tr>
            <td>{{ $attendee->user ? $attendee->user->name : 'DELETED USER' }}</td>
            <td>{{ $attendee->user ? $attendee->user->profile->phone : '' }}</td>
            <td>{{ $attendee->user ? $attendee->user->email : '' }}</td>
            <td>{{ $attendee->user ? ($attendee->user->organization ? $attendee->user->organization->name : '') : '' }}</td>

            @if($attendee->user)

            @if($attendee->user->organizations->count() > 0)
            @foreach($attendee->user->organizations as $organization)
            <td>{{ $organization->name }}</td>
            @endforeach
            @if($attendee->user->organizations->count() == 1)
            <td></td>
            @endif

            @else
            <td></td>
            <td></td>
            @endif

            @else
            <td></td>
            <td></td>
            @endif
            <td>{{ $attendee->created_at->format('m/d/Y H:i') }}</td>

        </tr>
        @endforeach




    </tbody>
</table>