<div>

    <div class="flex gap-3 mb-4">
        <div>
            <x-input class="max-w-xs" name="searchTerm" type="text" placeholder="User" wire:model="searchTerm" />
        </div>
        <div>
            <x-button wire:click.prevent="clear">Clear</x-button>
        </div>
    </div>

    <div class="divide-y divide-otgray border-t border-otgray">

        @foreach ($attendees as $attendee)
        <div x-data="{info:false}">
            <div class="p-2 {{ $attendee->checked_in ? 'bg-otgray-100' : '' }}" @click.away="info=false">
                @if($attendee->user)
                <div class="md:flex md:gap-3 md:items-center" @click="info=true">
                    <div class="flex-1 flex gap-3 items-center">
                        <div class="w-10">
                            <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-lg">{{ $attendee->user->name }}</div>
                            <div class="text-otsteel text-sm">{{ $attendee->user->email }}</div>
                        </div>
                    </div>
                    @if($attendee->user->organization)
                    <div class="md:w-1/2">
                        <div class="font-medium">
                            {{ $attendee->user->organization->name }}
                        </div>
                    </div>
                    @endif
                </div>
                <div x-show="info" class="pt-4 md:flex md:gap-3" style="display:none;">
                    <div class="md:flex-1">
                        @foreach($attendee->courseAttendees as $courseAttendee)
                        <div class="flex flex-wrap items-center mb-2 md:mb-1">
                            <div class="w-32 font-medium text-lg">
                                {{ $courseAttendee->course->start_date->format('l') }}
                            </div>
                            <div class="w-28">
                                {{ $courseAttendee->course->start_date->format('H:i') }} -
                                {{ $courseAttendee->course->end_date->format('H:i') }}
                            </div>
                            <div class="w-full md:w-auto">
                                <x-a href="{{ route('course', [$courseAttendee->course->conference, $courseAttendee->course]) }}" target="_blank">
                                    {{ $courseAttendee->course->name}}
                                </x-a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="md:w-48">
                        @if($attendee->checked_in)
                        <div class="font-medium text-lg">Checked In</div>
                        @if($attendee->checked_in_by_user_id)
                        <div>{{ $attendee->checkedInByUser->name }}</div>
                        <div>{{ $attendee->checked_in_at->format('d/m/Y H:i') }}</div>
                        @endif
                        @else
                        <x-button wire:click.prevent="checkin({{ $attendee->id }})">Check In</x-button>
                        @endif
                    </div>
                </div>
                @else
                DELETED USER
                @endif
            </div>
        </div>
        @endforeach

        <div class="p-4">
            {{ $attendees->links() }}
        </div>

        <table class="hidden">

            @foreach ($attendees as $attendee)
            <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                <td class="px-4 py-3">
                    <a class="flex gap-3 items-center" href="{{ route('admin.conference-attendees.show', [$attendee->conference, $attendee]) }}">
                        @if($attendee->user)
                        <div class="w-10">
                            <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-lg">{{ $attendee->user->name }}</div>
                            <div class="text-otsteel text-sm">{{ $attendee->user->email }}</div>
                        </div>
                        @else
                        DELETED USER
                        @endif
                    </a>
                </td>
                <td class="px-4 py-3">
                    @if($attendee->user)
                    @if($attendee->user->organization)
                    <div>
                        <a class="font-medium" href="{{ route('admin.organizations.show', $attendee->user->organization) }}">
                            {{ $attendee->user->organization->name }}
                        </a>
                    </div>
                    @endif
                    @if($attendee->user->organizations)
                    @foreach($attendee->user->organizations as $organization)
                    <div class="leading-tight">
                        <a class="font-medium text-sm" href="{{ route('admin.organizations.show', $organization) }}">
                            {{ $organization->name }}
                        </a>
                    </div>
                    @endforeach
                    @endif
                    @endif
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $attendee->package }} - ${{ $attendee->total }}
                </td>
                <td class="px-4 py-3 text-ellipsis overflow-hidden">
                    {{ $attendee->name }}
                    <div class="text-xs text-ellipsis overflow-hidden">
                        {{ $attendee->email }}
                    </div>
                </td>
                <td class="px-4 py-3 text-center">
                    {{ $attendee->courseAttendees->count() }}
                </td>

            </tr>
            @endforeach
        </table>
    </div>
</div>