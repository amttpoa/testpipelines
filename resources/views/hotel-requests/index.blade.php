<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Hotel Requests
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.conference-hotel-requests.export', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" download>Export Hotel Requests</a>
        </x-page-menu>
    </x-crumbs.bar>

    <div class="grid grid-cols-2 gap-6">
        <x-cards.main class="mb-6">
            <div class="flex gap-6 items-start">
                <table class="text-xl">
                    <tr>
                        <td class="text-right font-medium pr-2">Total:</td>
                        <td class="text-right">{{ $conference->conferenceHotelRequests->count() }}</td>
                    </tr>
                </table>
                <table class="text-xl">
                    @foreach($conference->conferenceHotelRequests->groupBy('room_type') as $key => $submission)
                    <tr>
                        <td class="text-right font-medium pr-2">{{ $key }}:</td>
                        <td>{{ $submission->count() }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </x-cards.main>
        <x-cards.main class="mb-6">
            <div class="">
                <form method="POST" action="{{ route('admin.conference-hotel-requests.store', $conference) }}">
                    @csrf
                    <div>
                        @livewire('user-autocomplete', ['user_id' => '', 'user_name' => ''] )
                    </div>
                    <div class="mt-4">
                        <x-button>Add User</x-button>
                    </div>
                </form>
            </div>
        </x-cards.main>
    </div>

    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Room Type</th>
                    <th class="px-4 py-3">Roomate</th>
                    <th class="px-4 py-3">Room</th>
                    <th class="px-4 py-3">Check In</th>
                    <th class="px-4 py-3">Check Out</th>
                    <th class="px-4 py-3">Comments</th>
                    <th class="px-4 py-3">Date Submitted</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($conference->conferenceHotelRequests->sortByDesc('created_at') as $request)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('admin.conference-hotel-requests.edit', [$conference, $request]) }}">
                            {{ $request->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <div>{{ $request->user->hasRole('Staff') ? 'Staff' : '' }}</div>
                        <div>{{ $request->user->hasRole('Conference Instructor') ? 'Conference Instructor' : '' }}</div>
                        <div>{{ $request->user->hasRole('VIP') ? 'VIP' : '' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        {{ $request->room_type }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $request->roommate }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $request->room }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $request->start_date ? $request->start_date->format('m/d/Y') : '' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $request->end_date ? $request->end_date->format('m/d/Y') : '' }}
                    </td>
                    <td class="px-4 py-3">
                        @if($request->notes->isNotEmpty())
                        <i class="fa-regular fa-note-sticky float-right ml-2 mb-2"></i>
                        @endif
                        {{ $request->comments }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $request->created_at->format('m/d/Y H:i') }}
                        <div class="text-xs">
                            {{ $request->created_at != $request->updated_at ? 'updated ' . $request->updated_at->format('m/d/Y H:i') : '' }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>