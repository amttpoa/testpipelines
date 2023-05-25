<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Events
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.events.create') }}">Create Event</x-button-link>
        </div>
    </x-crumbs.bar>


    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">Event</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-center">Region</th>
                            <th class="px-4 py-3 text-center">Attendees</th>
                            <th class="px-4 py-3 text-center">Active</th>
                            <th class="px-4 py-3">Venue</th>
                            <th class="px-4 py-3">Host</th>
                            <th class="px-4 py-3">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">
                        @foreach($events as $event)
                        <tr class=" {{ $loop->index % 2 > 0 ? 'bg-gray-100' : '' }}">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a>
                            </td>
                            <td class="px-4 py-3">{{ $event->start_date->format('m/d/Y H:i') }} - {{ $event->end_date->format('H:i') }}</td>
                            <td class="px-4 py-3 text-center">{{ $event->region }}</td>
                            <td class="px-4 py-3 text-center">{{ $event->eventAttendees->count() }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($event->active)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $event->venue ? $event->venue->name : '' }}</td>
                            <td class="px-4 py-3">{{ $event->user ? $event->user->name : '' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.events.edit', $event) }}">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-cards.plain>

</x-app-layout>