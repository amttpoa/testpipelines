<x-dashboard.layout>
    @section("pageTitle")
    My Organization
    @endSection

    <div class="lg:flex lg:gap-3 lg:flex-1">
        <x-breadcrumbs.holder class="flex-1">
            My Organization
        </x-breadcrumbs.holder>
        <div>
            @include('site.dashboard.organization.organization-chooser')
        </div>
    </div>

    <div class="font-medium text-2xl lg:text-4xl mb-8 text-center">
        {{ $organization->name }}
    </div>


    <div class="mb-12 flex gap-8 lg:items-center lg:justify-center flex-col lg:flex-row">
        <a class="flex gap-2 items-center" href="{{ route('dashboard.organization.users') }}">
            <div class="">
                <div class="border border-otgold rounded-full bg-otgold-100 overflow-hidden p-4">
                    <x-icons.users class="w-8 h-8 text-otgold" />
                </div>
            </div>
            <div>
                <div class="font-medium text-2xl leading-tight">
                    {{ $organization_users->count() }} User{{ $organization_users->count() > 1 ? 's' : '' }}
                </div>
                <div class="leading-tight">
                    in your organization
                </div>
            </div>
        </a>
        <a class="flex gap-2 items-center" href="{{ route('dashboard.organization.trainings.index') }}">
            <div class="">
                <div class="border border-otblue rounded-full bg-otblue-100 overflow-hidden p-4">
                    <x-icons.whiteboard class="w-8 h-8 text-otblue" />
                </div>
            </div>
            <div>
                <div class="font-medium text-2xl leading-tight">
                    Advanced Training
                </div>
                <div class="leading-tight">
                    for members in your organization
                </div>
            </div>
        </a>
        <a class="flex gap-2 items-center" href="{{ route('dashboard.organization.conferences.index') }}">
            <div class="">
                <div class="border border-otblue rounded-full bg-otblue-100 overflow-hidden p-4">
                    <x-icons.conference class="w-8 h-8 text-otblue" />
                </div>
            </div>
            <div>
                <div class="font-medium text-2xl leading-tight">
                    Conference Registration
                </div>
                <div class="leading-tight">
                    for members in your organization
                </div>
            </div>
        </a>
    </div>

    <x-info-h class="text-center">Team Memberships</x-info-h>
    <div class="mb-6">
        @foreach($organization->activeSubscriptions() as $subscription)
        <div>
            <span class="font-medium text-lg">{{ $subscription->authorize_plan }}</span>
            purchased by
            <x-a href="{{ route('dashboard.organization.user', $subscription->user) }}">{{ $subscription->user->name }}</x-a>
        </div>
        @foreach($subscription->children as $child)
        <div>
            <x-a href="{{ route('dashboard.organization.user', $child->user) }}">{{ $child->user->name }}</x-a>
        </div>
        @endforeach
        @endforeach
    </div>

    <x-info-h class="text-center">Upcoming conferences that members of your organization are attending</x-info-h>
    <div class="mb-3">
        @if($conferenceCalendar->isEmpty())
        <div class="text-center text-red-700">
            No upcoming conferences for members in your organization
        </div>
        @else
        <div class="border-t border-otgray bg-otgray-50">
            @foreach($conferenceCalendar as $index => $conference)
            <a href="{{ route('dashboard.organization.conferences.show', $conference[0]->conference) }}" class="block border-b border-otgray py-4 lg:px-4">
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
                            <div>Member{{ $conference->count() == 1 ? '' : 's' }}</div>
                            <div>Attending</div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
    <div class="text-center mb-10">
        <x-a class="" href="{{ route('dashboard.organization.conferences.index') }}">
            View all conferences for your organization
        </x-a>
    </div>



    <x-info-h class="text-center">Upcoming advanced training that members of your organization are attending</x-info-h>
    @if($organization_calendar->isEmpty())
    <div class="text-center text-red-700">
        No upcoming training for members in your organization
    </div>
    @else
    <div class="border-t border-otgray bg-otgray-50">
        @foreach ($organization_calendar as $attendee)
        <div class="border-b border-otgray py-4 lg:px-4 lg:items-center flex gap-3 flex-col lg:flex-row">
            <div class="lg:w-1/3">
                <a class="flex gap-3 items-center" href="{{ route('dashboard.organization.trainings.attendee', [$attendee->trainingCourse, $attendee]) }}">
                    <div class="w-16">
                        <x-profile-image class="w-16 h-16" :profile="$attendee->user->profile" />
                    </div>
                    <div class="flex-1 text-ellipsis overflow-hidden">
                        <div class="font-medium text-lg">{{ $attendee->user->name }}</div>
                        <div class="text-otsteel text-sm text-ellipsis overflow-hidden">{{ $attendee->user->email }}</div>
                    </div>
                </a>
            </div>
            <div class="lg:w-1/3">
                <a href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">
                    <div class="font-medium text-xl">{{ $attendee->trainingCourse->training->name }}</div>
                    <div class="font-medium text-sm">{{ $attendee->trainingCourse->venue->name }}</div>
                    <div class="text-otsteel text-sm">
                        {{ $attendee->trainingCourse->venue->city }},
                        {{ $attendee->trainingCourse->venue->state }}
                    </div>
                </a>
            </div>
            <div class="lg:flex-1">
                <a href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">
                    <div class="font-medium">
                        {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                        {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                    </div>
                    <div class="text-otsteel text-sm">
                        {{ $attendee->trainingCourse->start_date->diffForHumans() }}
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="text-center mt-2">
        <x-a class="" href="{{ route('dashboard.organization.trainings.index') }}">
            View all Advanced Training for members in your organization
        </x-a>
    </div>

</x-dashboard.layout>