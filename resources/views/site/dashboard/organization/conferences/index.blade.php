<x-dashboard.layout>
    @section("pageTitle")
    Conferences
    @endSection

    <div class="lg:flex lg:gap-3 lg:flex-1">
        <x-breadcrumbs.holder class="flex-1">
            <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
            <x-breadcrumbs.arrow />
            Conferences
        </x-breadcrumbs.holder>
        <div>
            @include('site.dashboard.organization.organization-chooser')
        </div>
    </div>

    <x-info-h>
        Conferences that members of your organization are attending
    </x-info-h>

    <div class="border-t border-otgray">
        @foreach($organization_calendar as $index => $conference)
        <a class="block border-b border-otgray py-4 lg:px-4" href="{{ route('dashboard.organization.conferences.show', $conference[0]->conference) }}">
            <div class="lg:flex lg:gap-3 lg:items-center">
                <div class="lg:flex-1">
                    <div class="font-medium text-2xl">
                        {{ $index }}
                    </div>
                    <div class="lg:flex lg:gap-4 lg:items-center">
                        <div class="text-lg">
                            {{ $conference[0]->conference->start_date->format('m/d/Y') }} -
                            {{ $conference[0]->conference->end_date->format('m/d/Y') }}
                        </div>
                        <div class="text-otgray text-sm">
                            {{ $conference[0]->conference->start_date->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="text-4xl font-medium">{{ $conference->count() }}</div>
                    <div class="flex-1 text-sm leading-tight">
                        <div>Member{{ $conference->count() > 1 ? 's' : '' }}</div>
                        <div>Attending</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- <div class="font-medium text-lg p-2 bg-otgray-800 text-white">
        Advanced Training for members in your organization
    </div>
    <x-dashboard.table>
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Name</th>
            <th class="px-2 py-1">Registered For</th>
            <th class="px-2 py-1">Hosted At</th>
        </tr>
        @foreach ($organization_calendar as $attendee)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1">
                <a class="flex gap-3 items-center" href="{{ route('dashboard.organization.user', $attendee->user) }}">
                    <div class="w-10">
                        <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-lg">{{ $attendee->user->name }}</div>
                        <div class="text-otsteel text-sm">{{ $attendee->user->email }}</div>
                    </div>
                </a>
            </td>
            <td class="px-2 py-1">
                <a href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">
                    <div class="font-medium text-lg">{{ $attendee->trainingCourse->training->name }}</div>
                    <div class="text-otsteel text-sm">
                        {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                        {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                    </div>
                </a>
            </td>
            <td class="px-2 py-1">
                <a href="{{ route('venue', $attendee->trainingCourse->venue) }}">
                    <div class="font-medium text-lg">{{ $attendee->trainingCourse->venue->name }}</div>
                    <div class="text-otsteel text-sm">
                        {{ $attendee->trainingCourse->venue->city }},
                        {{ $attendee->trainingCourse->venue->state }}
                    </div>
                </a>
            </td>
        </tr>
        @endforeach
    </x-dashboard.table> --}}


</x-dashboard.layout>