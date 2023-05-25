<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Conferences
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.conferences.create') }}">Create Conference</x-button-link>
        </div>
    </x-crumbs.bar>


    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">Conference</th>
                            <th class="px-4 py-3">Start</th>
                            <th class="px-4 py-3">End</th>
                            <th class="px-4 py-3 text-center">Visible</th>
                            <th class="px-4 py-3 text-center">Active</th>
                            <th class="px-4 py-3 text-center">Attendees</th>
                            <th class="px-4 py-3 text-center">Vendors</th>
                            <th class="px-4 py-3 text-center">Courses</th>
                            <th class="px-4 py-3 text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">
                        @foreach($conferences as $conference)
                        <tr class=" {{ $loop->index % 2 > 0 ? 'bg-gray-100' : '' }}">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</a>
                            </td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($conference->start_date)->format('F j, Y') }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($conference->end_date)->format('F j, Y') }}</td>
                            <td class="px-4 py-3 text-center">{{ $conference->conference_visible ? 'Visible' : '' }}</td>
                            <td class="px-4 py-3 text-center">{{ $conference->registration_active ? 'Active' : '' }}</td>
                            <td class="px-4 py-3 text-center">
                                <x-a href="{{ route('admin.conference-attendees.index', $conference) }}">
                                    {{ $conference->conferenceAttendees()->count() }}
                                </x-a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-a href="{{ route('admin.vendor-registration-submissions.index', $conference) }}">
                                    {{ $conference->vendors->count() }}
                                </x-a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-a href="{{ route('admin.courses.index', $conference) }}">
                                    {{ $conference->courses->count() }}
                                </x-a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-a href="{{ route('admin.conferences.edit', $conference) }}">
                                    Edit
                                </x-a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-cards.plain>

</x-app-layout>