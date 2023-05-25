<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Venues
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.venues.create') }}">Create Venue</x-button-link>
        </div>
    </x-crumbs.bar>


    <x-cards.plain>

        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Venue</th>
                    <th class="px-4 py-3">Contact Person</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3">City</th>
                    <th class="px-4 py-3">State</th>
                    <th class="px-4 py-3 text-center">Hotels</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($venues as $venue)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('admin.venues.show', $venue) }}">
                            {{ $venue->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        @if($venue->user)
                        <a href="{{ route('admin.users.show', $venue->user) }}">
                            {{ $venue->user->name }}
                        </a>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        {{ $venue->address }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $venue->city }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $venue->state }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        {{ $venue->hotels->count() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>