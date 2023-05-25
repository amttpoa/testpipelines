<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Medics
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.conference-venue-medics.create', $conference) }}">Create Medic</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Venue</th>
                    <th class="px-4 py-3">User</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($conference->venues as $venue)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-3 font-medium">
                        {{ $venue->name }}
                    </td>
                    <td class="px-4 py-3 font-medium">
                        @foreach($conferenceVenueMedics->where('venue_id', $venue->id)->sortBy('date') as $medic)
                        <div>
                            <a href="{{ route('admin.conference-venue-medics.edit', [$conference, $medic]) }}">
                                {{ $medic->user->name }}
                                {{ $medic->date ? ' - ' . $medic->date->format('m/d/Y') : '' }}
                                {{ $medic->note ? ' - ' . $medic->note : '' }}
                            </a>
                        </div>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>