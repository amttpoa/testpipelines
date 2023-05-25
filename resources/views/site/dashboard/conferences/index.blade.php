<x-dashboard.layout>
    @section("pageTitle")
    My Conferences
    @endSection

    <x-breadcrumbs.holder>
        Conferences
    </x-breadcrumbs.holder>

    <x-info-h>
        Conferences that you are registered for
    </x-info-h>

    @if(auth()->user()->conferenceAttendees->isNotEmpty())

    <div class="border-t border-otgray bg-otgray-50">
        @foreach(auth()->user()->conferenceAttendees as $attendee)
        <a href="{{ route('dashboard.conferences.show', $attendee) }}" class="block border-b border-otgray py-4 lg:px-4">
            <div class="lg:flex lg:gap-3 lg:items-center">
                <div class="lg:flex-1">
                    <div class="font-medium text-2xl">
                        {{ $attendee->conference->name }}
                    </div>
                    <div class="lg:flex lg:gap-4 lg:items-center">
                        <div class="text-lg">
                            {{ $attendee->conference->start_date->format('m/d/Y') }} -
                            {{ $attendee->conference->end_date->format('m/d/Y') }}
                        </div>
                        <div class="text-otgray text-sm">
                            {{ $attendee->conference->start_date->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="text-4xl font-medium">{{ $attendee->courseAttendees->count() }}</div>
                    <div class="flex-1 text-sm leading-tight">
                        <div>Course{{ $attendee->courseAttendees->count() == 1 ? '' : 's' }}</div>
                        <div>Attending</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @else

    <div class="text-lg">
        You are not registered for any conferences.
        Check out the <a class="text-otgold font-medium" href="{{ route('conferences') }}">Conferences</a> page to register for an upcoming conference.
    </div>

    @endif

</x-dashboard.layout>