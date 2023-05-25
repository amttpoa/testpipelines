<x-dashboard.layout>
    @section("pageTitle")
    {{ $conferenceAttendee->conference->name }} | Dashboard
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        {{ $conferenceAttendee->conference->name }}
    </x-breadcrumbs.holder>

    <div class="font-medium text-2xl">
        {{ $conferenceAttendee->conference->name }}
    </div>
    <div class="lg:flex lg:gap-4 lg:items-center mb-4">
        <div class="text-lg">
            {{ $conferenceAttendee->conference->start_date->format('m/d/Y') }} -
            {{ $conferenceAttendee->conference->end_date->format('m/d/Y') }}
        </div>
        <div class="text-otgray text-sm">
            {{ $conferenceAttendee->conference->start_date->diffForHumans() }}
        </div>
    </div>

    @if($conferenceAttendee->pay_type == 'invoice')
    <x-info-h class="mb-2">This person is responsible to receive and pay the conference invoice</x-info-h>
    <div class="mb-4 relative">
        <div class="font-medium text-2xl">{{ $conferenceAttendee->name }}</div>
        <div class="text-xl">{{ $conferenceAttendee->email }}</div>
        @if(!$conferenceAttendee->paid)
        <div class="mt-2">Need to make changes?
            email <x-a href="mailto:office@otoa.org">office@otoa.org</x-a>
        </div>
        <div>Payment is due by <strong>{{ $conferenceAttendee->conference->start_date->format('F j, Y') }}</strong></div>
        @else
        <div class="mt-2">Invoice has been paid</strong></div>
        <div class="rotate-[-12deg] absolute top-0 left-8 text-6xl font-bold opacity-50 text-red-500" style="font-family:'Times New Roman', Times, serif;">Paid</div>
        @endif
    </div>
    @endif

    @if($conferenceAttendee->pay_type == 'credit_card')
    <div class="font-medium text-xl">Paid by credit card</div>
    <div class="mb-4">
        {{ $conferenceAttendee->name }}
    </div>
    @endif


    <x-info-h class="mb-0">Courses you are registered for</x-info-h>
    <div class="mb-4 text-xs">
        After you complete a course, complete the course survey to download the course certificate.
    </div>

    <div class="border-t border-otgray bg-otgray-50">
        @foreach($courseAttendees as $attendee)
        <div class="border-b border-otgray py-4 lg:px-4">
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 items-center">
                <div class="col-span-2">
                    <div class="">
                        <a class="font-medium text-xl" href="{{ route('course', [$attendee->course->conference, $attendee->course]) }}">
                            {{ $attendee->course->name }}
                        </a>
                    </div>

                    <div class="text-sm">
                        <span class="text-lg mr-4">{{ $attendee->course->start_date->format('m/d/Y') }}</span>
                        {{ $attendee->course->start_date->format('h:i') }} - {{ $attendee->course->end_date->format('h:i') }}

                    </div>
                </div>
                <div class="text-sm">
                    <div>
                        @if($attendee->checked_in)
                        <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                            <i class="fa-solid fa-check w-5 text-center"></i> Checked In
                        </div>
                        @else
                        <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray bg-white">
                            <i class="fa-solid fa-x w-5 text-center"></i> Not Checked In
                        </div>
                        @endif
                    </div>
                </div>
                <div class="text-sm">
                    <div class="">
                        @if($attendee->completed)
                        <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                            <i class="fa-solid fa-check w-5 text-center"></i> Completed
                        </div>
                        @else
                        <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray bg-white">
                            <i class="fa-solid fa-x w-5 text-center"></i> Not Completed
                        </div>
                        @endif
                    </div>

                </div>
                <div class="">
                    <div class="font-medium">
                        @if($attendee->course->link_id == null)
                        @if($attendee->completed)

                        @if($attendee->surveyConferenceCourseSubmission)
                        <div class="text-otgray">
                            Survey Complete
                        </div>
                        <x-a href="{{ route('dashboard.conferences.certificate', $attendee) }}">
                            Download Certificate
                        </x-a>
                        @else
                        <x-a href="{{ route('dashboard.conferences.survey', $attendee) }}">
                            Complete Survey
                        </x-a>
                        <div class="text-otgray text-xs font-light">
                            To Download Certificate
                        </div>
                        @endif

                        @else
                        <div class="text-otgray">
                            Course Not Completed
                        </div>
                        @endif
                        @endif

                    </div>
                    <div class="">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>


    <x-dashboard.table class="hidden">
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Date</th>
            <th class="px-2 py-1">Time</th>
            <th class="px-2 py-1">Course</th>
            <th class="px-2 py-1">Venue</th>
        </tr>
        @foreach($courseAttendees as $attendee)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1 whitespace-nowrap">
                {{ $attendee->course->start_date->format('m/d/Y') }}
            </td>
            <td class="px-2 py-1 whitespace-nowrap">
                {{ $attendee->course->start_date->format('h:i') }} - {{ $attendee->course->end_date->format('h:i') }}
            </td>
            <td class="px-2 py-1">
                <x-a href="{{ route('course', [$attendee->course->conference, $attendee->course]) }}">
                    {{ $attendee->course->name }}
                </x-a>
            </td>
            <td class="px-2 py-1">
                @if($attendee->course->venue)
                <x-a href="{{ route('venue', $attendee->course->venue) }}">
                    {{ $attendee->course->venue->name }}
                </x-a>
                @endif
            </td>
            <td class="px-2 py-1">
                {{ $attendee->id }}
                <x-a href="{{ route('dashboard.conferences.certificate', $attendee) }}">
                    pdf
                </x-a>
            </td>
        </tr>
        @endforeach

    </x-dashboard.table>


</x-dashboard.layout>