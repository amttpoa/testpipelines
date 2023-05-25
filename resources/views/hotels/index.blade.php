<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Hotels
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.hotels.create') }}">Create Hotel</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.plain>

        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Hotel</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3">City</th>
                    <th class="px-4 py-3">State</th>
                    <th class="px-4 py-3 text-center">Venues</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($hotels as $hotel)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('admin.hotels.edit', $hotel) }}">
                            {{ $hotel->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $hotel->address }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $hotel->city }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $hotel->state }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        {{ $hotel->venues->count() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>