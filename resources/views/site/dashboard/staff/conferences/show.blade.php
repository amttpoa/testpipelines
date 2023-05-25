<x-dashboard.layout>
    @section("pageTitle")
    {{ $conference->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        {{ $conference->name }}
    </x-breadcrumbs.holder>

    <div class="lg:flex lg:gap-3">
        <div class="lg:flex-1">
            <div class="font-medium text-2xl">
                {{ $conference->name }}
            </div>
            <div class="lg:flex lg:gap-4 lg:items-center mb-4">
                <div class="text-lg">
                    {{ $conference->start_date->format('m/d/Y') }} -
                    {{ $conference->end_date->format('m/d/Y') }}
                </div>
                <div class="text-otgray text-sm">
                    {{ $conference->start_date->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="mb-4">
            @if(!auth()->user()->can('no-reimbursement'))

            @if($conference->reimbursements->where('user_id', auth()->user()->id)->first())

            @if($conference->reimbursements->where('user_id', auth()->user()->id)->first()->paid)
            <div class="text-center">
                <div class="font-medium text-lg">Paid</div>
                <div class="font-medium text-2xl">${{ number_format($conference->reimbursements->where('user_id', auth()->user()->id)->first()->total, 2) }}</div>
            </div>
            @else
            <x-button-link-site a href="{{ route('dashboard.staff.conferences.reimbursement', $conference) }}">Reimbursement</x-button-link-site>
            @endif

            @else
            <x-button-link-site a href="{{ route('dashboard.staff.conferences.reimbursement', $conference) }}">Reimbursement</x-button-link-site>
            @endif

            @endif
        </div>
    </div>

    <x-info-h>
        Conference courses you are teaching
    </x-info-h>


    <div class="border-t border-otgray bg-otgray-50">
        @foreach($courses as $course)
        <a class="" href="{{ route('dashboard.staff.courses.show', [$conference, $course]) }}">
            <div class="border-b border-otgray py-4 px-4">
                <div class="grid grid-cols-3 lg:grid-cols-5 gap-3 items-center">
                    <div class="col-span-3">
                        <div class="font-medium text-xl">
                            {{ $course->name }}
                        </div>
                        <div class="text-sm">
                            <span class="text-lg mr-4">{{ $course->start_date->format('m/d/Y') }}</span>
                            {{ $course->start_date->format('h:i') }} - {{ $course->end_date->format('h:i') }}
                        </div>
                    </div>

                    <div>
                        <span class="text-4xl font-medium">{{ $course->courseAttendees->count() }}</span>
                        <span class="text-xs">/ {{ $course->capacity }}</span>
                    </div>
                    <div class="text-sm">
                        <div>Checked In: <span class="font-medium">{{ $course->courseAttendees->where('checked_in')->count() }}</span></div>
                        <div>Complete: <span class="font-medium">{{ $course->courseAttendees->where('completed')->count() }}</span></div>
                    </div>

                </div>
            </div>
        </a>
        @endforeach
    </div>



    <x-dashboard.table class="hidden">
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


</x-dashboard.layout>