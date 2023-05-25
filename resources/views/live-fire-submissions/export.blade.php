<table>
    <thead>
        <tr>
            <th>Comapny</th>
            <th>Bringing</th>
            <th>Firearm</th>
            <th>Caliber</th>
            <th>Share</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($liveFireSubmissions as $liveFireSubmission)
        <tr>
            <td>{{ $liveFireSubmission->vendorRegistrationSubmission->organization->name }}</td>
            <td>{{ $liveFireSubmission->bringing }}</td>
            <td>{{ $liveFireSubmission->firearm }}</td>
            <td>{{ $liveFireSubmission->caliber }}</td>
            <td>
                {{ $liveFireSubmission->share }}
                @if($liveFireSubmission->share == 'Yes')
                - {{ $liveFireSubmission->share_with }}
                @endif
            </td>
            <td>{{ $liveFireSubmission->description }}</td>

        </tr>
        @endforeach
    </tbody>
</table>