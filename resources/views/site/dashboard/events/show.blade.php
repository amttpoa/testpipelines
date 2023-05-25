<x-dashboard.layout>
    @section("pageTitle")
    {{ $event->name }}
    @endSection

    <x-breadcrumbs.holder>
        {{ $event->name }}
    </x-breadcrumbs.holder>

    <div class="md:flex gap-3 mb-8">
        <div class="flex-1">
            <div>
                <div class="text-2xl font-medium">{{ $event->name }}</div>
                <div class="text-lg font-medium">
                    <span class="font-medium">{{ $event->start_date->format('m/d/Y') }}</span>
                    <span class="text-otgray ml-3">
                        {{ $event->start_date->format('H:i') }} -
                        {{ $event->end_date->format('H:i') }}
                    </span>
                </div>
                <div class="text-otgray text-sm">{{ $event->region ? 'Region ' . $event->region : '' }}</div>
            </div>
            <div>
                @if($event->venue)
                <div class="font-medium text-lg">{{ $event->venue->name }}</div>
                @endif
            </div>
        </div>
        <div>
            <div class="flex gap-2 items-center">
                <div class="text-4xl font-medium">
                    {{ $event->eventAttendees->count() }}
                    <span class="text-xs">/ {{ $event->capacity }}</span>
                </div>
                <div class="flex-1 text-sm leading-tight">
                    <div>Member{{ $event->eventAttendees->count() > 1 ? 's' : '' }}</div>
                    <div>Registered</div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
        @foreach($event->eventAttendees->sortBy('user.name') as $attendee)
        <div class="block border-b border-otgray py-4 px-4">
            <div class="lg:flex lg:gap-3 lg:items-center">
                <div class="lg:w-14 flex gap-4 items-center mb-2 lg:mb-0">
                    <x-profile-image :profile="$attendee->user->profile" class="w-14 h-14" />
                    <div class="flex-1 font-medium text-2xl lg:hidden">
                        {{ $attendee->user->name }}
                    </div>
                </div>
                <div class="lg:flex-1">
                    <div class="font-medium text-2xl hidden lg:block">
                        {{ $attendee->user->name }}
                    </div>
                    <div class="lg:flex lg:gap-4 lg:items-center">
                        @if($attendee->user->profile->phone)
                        <div class="text-lg">
                            {{ $attendee->user->profile->phone }}
                        </div>
                        @endif
                        <div class="text-otgray text-sm">
                            {{ $attendee->user->email }}
                        </div>
                    </div>
                    <div class="text-sm text-otgray">
                        {{ $attendee->comments }}
                    </div>
                </div>
                <div class="font-medium lg:text-right">
                    <div>{{ $attendee->user->organization ? $attendee->user->organization->name : ''}}</div>
                    @foreach($attendee->user->organizations as $organization)
                    <div class="text-sm">{{ $organization->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>



</x-dashboard.layout>