@if($type == 'attendees')


<table>
    <thead>
        <tr>
            <th>Comapny Name</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conference->vendors as $vendor)
        @foreach($vendor->attendees as $attendee)
        <tr>
            <td>{{ $vendor->organization->name }}</td>
            <td>{{ $attendee->name }}</td>
            <td>{{ $attendee->email }}</td>
            <td>{{ $attendee->phone }}</td>
        </tr>
        @endforeach

        @endforeach
    </tbody>
</table>

@else


<table>
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Website</th>
            <th>Sponsorship</th>
            <th>Live Fire</th>
            <th>Lunch</th>
            <th>Power</th>
            <th>Tv</th>
            <th>Internet</th>
            <th>Tables</th>
            <th>Public</th>
            <th>Paid</th>
            <th>Sponsorship</th>
            <th>Live Fire</th>
            <th>Lunch</th>
            <th>Power</th>
            <th>TV</th>
            <th>Internet</th>
            <th>Tables</th>
            <th>Total</th>
            <th>Lunch Qty</th>
            <th>Tables Qty</th>
            <th>Comments</th>
            <th>Primary Name</th>
            <th>Primary Email</th>
            <th>Primary Phone</th>
            <th>Advertising Name</th>
            <th>Advertising Email</th>
            <th>Advertising Phone</th>
            <th>Live Fire Name</th>
            <th>Live Fire Email</th>
            <th>Live Fire Phone</th>
            <th>Billing Name</th>
            <th>Billing Email</th>
            <th>Billing Phone</th>
            <th>Bringing</th>
            <th>Firearm</th>
            <th>Caliber</th>
            <th>Share</th>
            <th>Description</th>
            <th>Representatives</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conference->vendors as $vendor)
        <tr>
            <td>{{ $vendor->organization->name }}</td>
            <td>{{ $vendor->organization->website }}</td>
            <td>{{ $vendor->sponsorship }}</td>
            <td>{{ $vendor->live_fire }}</td>
            <td>{{ $vendor->lunch }}</td>
            <td>{{ $vendor->power }}</td>
            <td>{{ $vendor->tv }}</td>
            <td>{{ $vendor->internet }}</td>
            <td>{{ $vendor->tables }}</td>


            <td>{{ $vendor->public ? 'Public' : '' }}</td>
            <td>{{ $vendor->paid ? 'Paid' : '' }}</td>
            <td>{{ $vendor->sponsorship_price }}</td>
            <td>{{ $vendor->live_fire_price }}</td>
            <td>{{ $vendor->lunch_price }}</td>
            <td>{{ $vendor->power_price }}</td>
            <td>{{ $vendor->tv_price }}</td>
            <td>{{ $vendor->internet_price }}</td>
            <td>{{ $vendor->tables_price }}</td>
            <td>{{ $vendor->total }}</td>
            <td>{{ $vendor->lunch_qty }}</td>
            <td>{{ $vendor->tables_qty }}</td>

            <td>{{ $vendor->comments }}</td>

            <td>{{ $vendor->user ? $vendor->user->name : 'DELETED USER' }}</td>
            <td>{{ $vendor->user ? $vendor->user->email : '' }}</td>
            <td>{{ $vendor->user ? $vendor->user->profile->phone : '' }}</td>

            <td>{{ $vendor->advertising_name }}</td>
            <td>{{ $vendor->advertising_email }}</td>
            <td>{{ $vendor->advertising_phone }}</td>
            <td>{{ $vendor->live_fire_name }}</td>
            <td>{{ $vendor->live_fire_email }}</td>
            <td>{{ $vendor->live_fire_phone }}</td>
            <td>{{ $vendor->billing_name }}</td>
            <td>{{ $vendor->billing_email }}</td>
            <td>{{ $vendor->billing_phone }}</td>

            @if($vendor->liveFireSubmission)
            <td>{{ $vendor->liveFireSubmission->bringing }}</td>
            <td>{{ $vendor->liveFireSubmission->firearm }}</td>
            <td>{{ $vendor->liveFireSubmission->caliber }}</td>
            <td>
                {{ $vendor->liveFireSubmission->share }}
                @if($vendor->liveFireSubmission->share == 'Yes')
                - {{ $vendor->liveFireSubmission->share_with }}
                @endif
            </td>
            <td>{{ $vendor->liveFireSubmission->description }}</td>
            @else
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @endif

            @foreach($vendor->attendees as $attendee)
            <td>{{ $attendee->name }}</td>
            <td>{{ $attendee->email }}</td>
            <td>{{ $attendee->phone }}</td>
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>

@endif