<table>
    <thead>
        <tr class="font-bold">
            <th>Name</th>
            <th>Email</th>
            <th>Organization</th>
            <th>Total</th>
            <th>Pay Method</th>
            <th>Name</th>
            <th>Email</th>
            <th>Member</th>
            <th>Invoiced</th>
            <th>Paid</th>
            <th>Checked In</th>
            <th>Completed</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trainingCourse->attendees as $attendee)
        <tr>
            <td>{{ $attendee->user->name }}</td>
            <td>{{ $attendee->user->email }}</td>
            <td>{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</td>
            <td>{{ $attendee->total }}</td>
            <td>{{ $attendee->pay_type }}</td>
            <td>{{ $attendee->name }}</td>
            <td>{{ $attendee->email }}</td>
            <td>{{ $attendee->user->subscribed() ? 'X' : '' }}</td>
            <td>{{ $attendee->invoiced ? 'X' : '' }}</td>
            <td>{{ $attendee->paid ? 'X' : '' }}</td>
            <td>{{ $attendee->checked_in ? 'X' : '' }}</td>
            <td>{{ $attendee->completed ? 'X' : '' }}</td>
            <td>{{ $attendee->notes }}</td>

        </tr>
        @endforeach
    </tbody>
</table>