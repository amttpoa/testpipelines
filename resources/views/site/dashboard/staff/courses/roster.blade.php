<x-dashboard.layout>
    @section("pageTitle")
    Roster
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index', $course->conference) }}">Conferences</a>
        <x-breadcrumbs.arrow />
        {{ $course->name }}
        <x-breadcrumbs.arrow />
        Roster
    </x-breadcrumbs.holder>

    <x-dashboard.table>
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Name</th>
            <th class="px-2 py-1">Organization</th>
            <th class="px-2 py-1">Email</th>
            <th class="px-2 py-1">Phone</th>
        </tr>

        @foreach($course->courseAttendees as $attendee)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1">{{ $attendee->user->name }}</td>
            <td class="px-2 py-1">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</td>
            <td class="px-2 py-1">{{ $attendee->user->email }}</td>
            <td class="px-2 py-1">{{ $attendee->user->profile->phone }}</td>
        </tr>
        @endforeach
    </x-dashboard.table>

</x-dashboard.layout>