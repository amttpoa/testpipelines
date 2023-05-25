<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            {{ $conference->name }}
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.conferences.edit', $conference) }}">Edit Conference</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6 items-center mb-6">

        <a href="{{ route('admin.conference-attendees.index', $conference) }}">
            <x-cards.main class="flex gap-4 items-center">
                <div class="">
                    <div class="border border-otsteel rounded-full bg-otsteel-100 overflow-hidden p-4">
                        <x-icons.users class="w-10 h-10 text-otsteel" />
                    </div>
                </div>
                <div>
                    <div class="font-medium text-2xl leading-tight">
                        Attendees
                    </div>
                    <div class="text-lg leading-tight">
                        {{ $conference->conferenceAttendees->count() }} Total
                    </div>
                    <div class="text-lg leading-tight">
                        {{ $conference->conferenceAttendees->where('paid')->count() }} Paid
                    </div>
                </div>
            </x-cards.main>
        </a>

        <a href="{{ route('admin.vendor-registration-submissions.index', $conference) }}">
            <x-cards.main class="flex gap-4 items-center">
                <div class="">
                    <div class="border border-otgold rounded-full bg-otgold-100 overflow-hidden p-4">
                        <x-icons.businessman class="w-8 h-8 text-otgold" />
                    </div>
                </div>
                <div>
                    <div class="font-medium text-2xl leading-tight">
                        Vendors
                    </div>
                    <div class="text-lg leading-tight">
                        {{ $conference->vendors->count() }} Total
                    </div>
                    <div class="text-lg leading-tight">
                        {{ $conference->vendors->where('public')->count() }} Public
                    </div>
                </div>
            </x-cards.main>
        </a>

        <a href="{{ route('admin.courses.index', $conference) }}">
            <x-cards.main class="flex gap-4 items-center">
                <div class="">
                    <div class="border border-otblue rounded-full bg-otblue-100 overflow-hidden p-4">
                        <x-icons.whiteboard class="w-8 h-8 text-otblue" />
                    </div>
                </div>
                <div>
                    <div class="font-medium text-2xl leading-tight">
                        Courses
                    </div>
                    <div class="text-lg leading-tight">
                        {{ $conference->courses->count() }} Total
                    </div>
                </div>
            </x-cards.main>
        </a>

        <a href="{{ route('admin.conferences.edit', $conference) }}">
            <x-cards.main class="flex gap-4 items-center">
                <div class="">
                    <div class="border border-black rounded-full bg-otgray-100 overflow-hidden p-4">
                        <x-icons.question class="w-8 h-8 text-black" />
                    </div>
                </div>
                <div>
                    <div class="font-medium text-2xl leading-tight">

                    </div>
                    <div class="text-xs leading-tight">
                        @if($conference->conference_visible)
                        <span class="font-medium">Conference Visible</span>
                        @else
                        <span class="text-otgray">Conference Not Visible</span>
                        @endif
                    </div>
                    <div class="text-xs leading-tight">
                        @if($conference->courses_visible)
                        <span class="font-medium">Courses Visible</span>
                        @else
                        <span class="text-otgray">Courses Not Visible</span>
                        @endif
                    </div>
                    <div class="text-xs leading-tight">
                        @if($conference->vendor_active)
                        <span class="font-medium">Vendor Registration Active</span>
                        @else
                        <span class="text-otgray">Vendor Registration Not Active</span>
                        @endif
                    </div>
                    <div class="text-xs leading-tight">
                        @if($conference->registration_active)
                        <span class="font-medium">Attendee Registration Active</span>
                        @else
                        <span class="text-otgray">Attendee Registration Not Active</span>
                        @endif
                    </div>
                </div>
            </x-cards.main>
        </a>

    </div>


    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

        <x-cards.main class="">
            @can('hotel-requests')
            <div>
                <x-a href="{{ route('admin.conference-hotel-requests.index', $conference) }}">Hotel Requests</x-a>
            </div>
            @endcan

            @can('live-fire')
            <div>
                <x-a href="{{ route('admin.live-fire-submissions.index', $conference) }}">Live Fire</x-a>
            </div>
            @endcan

            @can('full-access')
            <div>
                <x-a href="{{ route('admin.reimbursements.index', $conference) }}">Reimbursements</x-a>
            </div>
            <div>
                <x-a href="{{ route('admin.conference-venue-medics.index', $conference) }}">Medics</x-a>
            </div>
            <div>
                <x-a href="{{ route('admin.conference-attendees.badge', $conference) }}">Badge</x-a>
            </div>
            @endcan

            <div class="font-medium text-xl mt-4">Venues</div>
            @foreach($conference->venues as $venue)
            <div>
                <x-a class="" href="{{ route('admin.venues.show', $venue) }}">{{ $venue->name }}</x-a>
                - {{ $conference->courses->where('venue_id', $venue->id)->count() }}
            </div>
            @endforeach

            <div class="font-medium text-xl mt-4">Medics</div>
            @foreach($conference->venueMedics as $user)
            <div>
                <x-a class="" href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</x-a>
            </div>
            @endforeach

        </x-cards.main>

        <x-cards.main class="xl:col-span-3">
            <div class="mb-2 font-medium text-xl">{{ $conference->instructors()->count() }} Instructors</div>
            <div class="columns-2 xl:columns-4">
                @foreach($conference->instructors() as $user)
                <div class="mb-2">
                    <a class="flex gap-2 items-center font-medium" href="{{ route('admin.users.show', $user) }}">
                        <x-profile-image :profile="$user->profile" class="h-8 w-8" />
                        {{ $user->name }}
                        @if($conference->conferenceHotelRequests->contains('user_id', $user->id))
                        - H
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </x-cards.main>

    </div>

</x-app-layout>