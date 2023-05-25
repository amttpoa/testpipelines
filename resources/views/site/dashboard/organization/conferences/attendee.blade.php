<x-dashboard.layout>
    @section("pageTitle")
    {{ $conferenceAttendee->user->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.conferences.show', $conference) }}">{{ $conference->name }}</a>
        <x-breadcrumbs.arrow />
        {{ $conferenceAttendee->user->name }}
    </x-breadcrumbs.holder>

    <div class="font-medium text-2xl">
        <a href="{{ route('dashboard.organization.conferences.show', $conference) }}">{{ $conference->name }}</a>
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

    <div class="lg:flex lg:gap-4 lg:items-center mb-8">
        <div class="text-xl font-light">
            Courses for
        </div>
        <div class="lg:flex-1">
            <a class="flex gap-3 items-center" href="{{ route('dashboard.organization.user', $conferenceAttendee->user) }}">
                <div class="w-16">
                    <x-profile-image class="w-16 h-16" :profile="$conferenceAttendee->user->profile" />
                </div>
                <div class="flex-1 text-ellipsis overflow-hidden">
                    <div class="font-medium text-xl">{{ $conferenceAttendee->user->name }}</div>
                    <div class="text-otsteel text-sm text-ellipsis overflow-hidden">{{ $conferenceAttendee->user->email }}</div>
                </div>
            </a>
        </div>
    </div>

    <div class="border-t border-otgray">
        @foreach ($conferenceAttendee->courseAttendees as $attendee)
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 items-center border-b border-otgray py-4 lg:px-4">
            <div class="col-span-2">
                <div class="font-medium text-xl">{{ $attendee->course->name }}</div>
                <div>
                    {{ $attendee->course->start_date->format('m/d/Y H:i') }} -
                    {{ $attendee->course->end_date->format('H:i') }}
                </div>
            </div>
            <div class="text-sm">
                <div>
                    @if($attendee->checked_in)
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                        <i class="fa-solid fa-check w-5 text-center"></i> Checked In
                    </div>
                    @else
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
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
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
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
                    <div class="leading-tight text-red-800">
                        Inform Member to Complete Survey
                    </div>
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
        @endforeach
    </div>


</x-dashboard.layout>