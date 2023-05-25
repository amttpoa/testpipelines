<x-dashboard.layout>
    @section("pageTitle")
    {{ $conference->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        {{ $conference->name }}
    </x-breadcrumbs.holder>

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


    <x-info-h>
        Members of your organization attending this conference
    </x-info-h>

    <div class="border-t border-otgray">
        @foreach ($conference_attendees as $attendee)
        <a href="{{ route('dashboard.organization.conferences.attendee', [$conference, $attendee]) }}" class="grid lg:grid-cols-5 gap-3 items-center border-b border-otgray py-4 lg:px-4">
            <div class="lg:col-span-2">
                <div class="flex gap-3 items-center">
                    <div class="w-16">
                        <x-profile-image class="w-16 h-16" :profile="$attendee->user->profile" />
                    </div>
                    <div class="flex-1 text-ellipsis overflow-hidden">
                        <div class="font-medium text-xl">{{ $attendee->user->name }}</div>
                        <div class="text-otsteel text-sm text-ellipsis overflow-hidden">{{ $attendee->user->email }}</div>
                    </div>
                </div>
            </div>
            <div class="text-xl font-medium">
                {{ $attendee->courseAttendees->count() }} Course{{ $attendee->courseAttendees->count() == 1 ? '' : 's' }}
            </div>
            <div class="text-xs lg:col-span-2">
                @foreach($attendee->courseAttendees as $courseAttendee)
                <div>{{ $courseAttendee->course ? $courseAttendee->course->name : '' }}</div>
                @endforeach
            </div>
        </a>
        @endforeach
    </div>


</x-dashboard.layout>