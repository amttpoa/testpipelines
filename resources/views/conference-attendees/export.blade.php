<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Organization</th>
            <th>Region</th>
            <th>Organization 2</th>
            <th>Region 2</th>
            <th>Organization 3</th>
            <th>Region 3</th>
            <th>Package</th>
            <th>Total</th>
            <th>Payer</th>
            <th>Email</th>
            <th>Courses</th>
            <th>Badge First Name</th>
            <th>Badge Last Name</th>
            <th>Badge Type</th>
            <th>Full Comp</th>
            <th>Invoiced</th>
            <th>Paid</th>
            <th>Checked In</th>
            <th>Completed</th>
            <th>Member</th>
            <th>Conference Instructor</th>
            <th>Staff</th>
            <th>Medic</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conference->conferenceAttendees as $attendee)
        <tr>
            <td>{{ $attendee->user ? $attendee->user->name : 'DELETED USER' }}</td>
            <td>{{ $attendee->user ? $attendee->user->email : '' }}</td>
            <td>{{ $attendee->user ? ($attendee->user->organization ? $attendee->user->organization->name : '') : '' }}</td>
            <td>{{ $attendee->user ? ($attendee->user->organization ? $attendee->user->organization->region : '') : '' }}</td>

            @if($attendee->user)

            @if($attendee->user->organizations->count() > 0)
            @foreach($attendee->user->organizations as $organization)
            <td>{{ $organization->name }}</td>
            <td>{{ $organization->region }}</td>
            @endforeach
            @if($attendee->user->organizations->count() == 1)
            <td></td>
            <td></td>
            @endif

            @else
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @endif

            @else
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @endif

            <td>{{ $attendee->package }}</td>
            <td>{{ $attendee->total }}</td>
            <td>{{ $attendee->name }}</td>
            <td>{{ $attendee->email }}</td>
            <td>{{ $attendee->courseAttendees->count() }}</td>
            <td>{{ $attendee->card_first_name }}</td>
            <td>{{ $attendee->card_last_name }}</td>
            <td>{{ $attendee->card_type }}</td>
            <td>{{ $attendee->comp ? 'Full Comp' : '' }}</td>
            <td>{{ $attendee->invoiced ? 'Invoiced' : '' }}</td>
            <td>{{ $attendee->paid ? 'Paid' : '' }}</td>
            <td>{{ $attendee->checked_id ? 'Checked In' : '' }}</td>
            <td>{{ $attendee->checked_id ? 'Completed' : '' }}</td>
            <td>{{ $attendee->user->subscribed() ? 'Member' : '' }}</td>
            <td>{{ $attendee->user->hasRole('Conference Instructor') ? 'Conference Instructor' : '' }}</td>
            <td>{{ $attendee->user->hasRole('Staff') ? 'Staff' : '' }}</td>
            <td>{{ $attendee->user->hasRole('Medic') ? 'Medic' : '' }}</td>

        </tr>
        @endforeach




    </tbody>
</table>