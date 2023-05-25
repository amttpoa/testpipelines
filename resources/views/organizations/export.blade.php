<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Leader</th>
            <th>Address</th>
            <th>Address 2</th>
            <th>Cite</th>
            <th>State</th>
            <th>Zip</th>
            <th>County</th>
            <th>Region</th>
            <th>Phone</th>
            <th>Fax</th>
            <th>Email</th>
            <th>Website</th>
        </tr>
    </thead>
    <tbody>
        @foreach($organizations as $organization)
        <tr>
            <td>{{ $organization->name }}</td>
            <td>{{ $organization->organization_type }}</td>
            <td>{{ $organization->leader }}</td>
            <td>{{ $organization->address }}</td>
            <td>{{ $organization->address2 }}</td>
            <td>{{ $organization->city }}</td>
            <td>{{ $organization->state }}</td>
            <td>{{ $organization->zip }}</td>
            <td>{{ $organization->county }}</td>
            <td>{{ $organization->region }}</td>
            <td>{{ $organization->phone }}</td>
            <td>{{ $organization->fax }}</td>
            <td>{{ $organization->email }}</td>
            <td>{{ $organization->website }}</td>
        </tr>

        @endforeach
    </tbody>
</table>