<x-dashboard.layout>
    @section("pageTitle")
    Courses
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.conferences.show', $conference) }}">{{ $conference->name }}</a>
        <x-breadcrumbs.arrow />
        Courses
    </x-breadcrumbs.holder>


    @if($courses->isEmpty())

    <div class="text-xl">You have not been assigned any conference courses to teach.</div>

    @else

    <div class="text-xl mb-4">
        Here are all the conference courses you are teaching.
    </div>

    <x-dashboard.table>
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Date</th>
            <th class="px-2 py-1">Name</th>
            <th class="px-2 py-1 text-center">Attendees</th>
            <th class="px-2 py-1 text-center whitespace-nowrap">Checked In</th>
            <th class="px-2 py-1 text-center">Complete</th>
            <th class="px-2 py-1 text-center">Edit</th>
        </tr>
        @foreach($courses as $course)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1 whitespace-nowrap"><a href="{{ route('dashboard.staff.course-attendees.index', [$conference, $course]) }}">{{ $course->start_date->format('F j') }}, {{ $course->start_date->format('h:i') }} - {{ $course->end_date->format('h:i') }}</a></td>
            <td class="px-2 py-1"><a class="font-medium" href="{{ route('dashboard.staff.courses.show', [$conference, $course]) }}">{{ $course->name }}</a></td>
            <td class="px-2 py-1 text-center"><a class="font-medium text-otgold" href="{{ route('dashboard.staff.course-attendees.index', [$conference, $course]) }}">{{ $course->courseAttendees->count() }}</a> <span class="text-xs">/{{ $course->capacity }}</span></td>
            <td class="px-2 py-1 text-center">{{ $course->courseAttendees->where('checked_in')->count() }}</td>
            <td class="px-2 py-1 text-center">{{ $course->courseAttendees->where('completed')->count() }}</td>
            <td class="px-2 py-1 text-center"><a class="font-medium text-otgold" href="{{ route('dashboard.staff.courses.edit', [$conference, $course]) }}">Edit</a></td>
        </tr>
        @endforeach
    </x-dashboard.table>
    @endif

</x-dashboard.layout>