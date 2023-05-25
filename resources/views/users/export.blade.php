<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Organization</th>
            <th>Region</th>
            <th>Plan</th>
            <th>Phone</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Birthday</th>
            <th>Shirt</th>
            <th>Waist</th>
            <th>Inseam</th>
            <th>Shoes</th>
            <th>Roles</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->organization ? $user->organization->name : '' }}</td>
            <td>{{ $user->organization ? $user->organization->region : '' }}</td>
            <td>
                @if ($user->subscription('default'))
                @foreach ($user->subscriptions->where('stripe_status', 'active') as $subscription)
                {{ $plans->where('stripe_plan', $subscription->stripe_price)->first()->slug }}
                @endforeach
                @endif
            </td>
            <td>{{ $user->profile->phone }}</td>
            <td>{{ $user->profile->address }}</td>
            <td>{{ $user->profile->city }}</td>
            <td>{{ $user->profile->state }}</td>
            <td>{{ $user->profile->zip }}</td>
            <td>{{ $user->profile->birthday ? \Carbon\Carbon::parse($user->profile->birthday)->format('m/d/Y') : '' }}</td>
            <td>{{ $user->profile->shirt_size }}</td>
            <td>{{ $user->profile->pants_waist }}</td>
            <td>{{ $user->profile->pants_inseam }}</td>
            <td>{{ $user->profile->shoe_size }}</td>
            <td>
                @foreach($user->roles as $role)
                {{ $role->name }}{{ !$loop->last ? ',' : '' }}
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>