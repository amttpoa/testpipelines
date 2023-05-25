<x-app-layout>
    <div class="flex gap-6">
        <x-cards.main class="mb-6 flex-1">
            <h2 class="font-medium text-2xl">Admin Dashboard</h2>
        </x-cards.main>

        <x-cards.main class="mb-6 hidden">

        </x-cards.main>

    </div>


    @can('full-access')

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @foreach($trainingCourses as $course)
        <a href="{{ route('admin.training-courses.show', [$course->training, $course]) }}">
            <x-cards.main class="flex flex-col h-full">
                <div class="font-medium text-xl">
                    {{ $course->training->name }}
                </div>
                <div class="">
                    {{ $course->start_date->format('m/d/Y') }} -
                    {{ $course->end_date->format('m/d/Y') }}
                </div>
                <div class="text-sm">
                    {{ $course->venue ? $course->venue->name : '' }}
                </div>
                <div class="text-sm mb-2 flex-1">
                    {{ $course->user ? $course->user->name : '' }}
                </div>
                <div class="flex">
                    <div class="font-medium text-lg flex-1">
                        {{ $course->attendees->count() }} of
                        {{ $course->capacity }} filled
                    </div>
                    <div>
                        {{ $course->trainingWaitlists->count() }} waitlist
                    </div>
                </div>
            </x-cards.main>
        </a>
        @endforeach
    </div>

    @if($users->isNotEmpty())
    <x-cards.plain class="mb-6">
        <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
            Users Not Connected
        </div>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Company Name Submitted</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">

                @foreach($users as $user)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1">
                        <a class="font-medium" href="{{ route('admin.users.show', $user ) }}">{{ $user->name }}</a>
                        <span class="ml-3">{{ $user->roles()->pluck('name')->implode(', ') }}</span>
                    </td>
                    <td class="px-4 py-1">
                        {{ $user->profile->organization_name }}
                    </td>
                    <td class="px-4 py-1">
                        @if($user->profile->organization_name)

                        @php
                        $orgs = $allOrganizations->where('name', $user->profile->organization_name);
                        @endphp

                        @if($orgs->isNotEmpty())
                        @foreach($orgs as $org)
                        <form method="POST" action="{{ route('admin.organizations.link',  [$org, $user]) }}">
                            @csrf
                            <button class="font-medium text-otgold">Link</button>
                            {{ $user->name }}
                            to
                            <x-a href="{{ route('admin.organizations.show', $org ) }}">
                                {{ $org->name }}
                            </x-a>
                        </form>
                        @endforeach
                        @else
                        <form method="POST" action="{{ route('admin.organizations.create-and-link',  $user) }}">
                            @csrf
                            <button class="font-medium text-otgold">Create</button>
                            {{ $user->can('vendor') ? 'Vendor' : 'Customer' }} company
                            <span class="font-medium">{{ $user->profile->organization_name }}</span>
                            and attach
                            {{ $user->name }}
                        </form>
                        @endif

                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </x-admin.table>
    </x-cards.plain>
    @endif

    <div class="grid sm:grid-cols-2 gap-6">
        <x-cards.plain>
            <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
                Most Recent Vendor Registrations
            </div>
            <x-admin.table>
                <thead class="">
                    <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                        <th class="px-4 py-3">Company</th>
                        <th class="px-4 py-3">Submitted</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-ot-steel">

                    @foreach ($submissions as $submission)
                    <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                        <td class="px-4 py-1 font-medium">
                            <a class="" href="{{ route('admin.vendor-registration-submissions.show', [$submission->conference, $submission]) }}">
                                @if($submission->organization)
                                {{ $submission->organization->name }}
                                @else
                                {{ $submission->company_name }}
                                @endif
                            </a>
                        </td>
                        <td class="px-4 py-1">
                            {{ $submission->created_at->format('m/d/Y H:i:s') }}
                            <span class="text-otgray text-sm ml-2">({{ $submission->created_at->diffForHumans() }})</span>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </x-admin.table>
        </x-cards.plain>

        <x-cards.plain>
            <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
                Most Recent Organizations Edited
            </div>
            <x-admin.table>
                <thead class="">
                    <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                        <th class="px-4 py-3">Organization</th>
                        <th class="px-4 py-3">Edited Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-ot-steel">
                    @foreach ($organizations as $organization)
                    <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                        <td class="px-4 py-1 font-medium">
                            <a class="" href="{{ route('admin.organizations.show', $organization) }}">
                                {{ $organization->name }}
                            </a>
                        </td>
                        <td class="px-4 py-1 whitespace-nowrap">
                            {{ $organization->updated_at->format('m/d/Y H:i:s') }}
                            <span class="text-otgray text-sm ml-2">({{ $organization->updated_at->diffForHumans() }})</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        </x-cards.plain>

    </div>


    <div class="grid sm:grid-cols-2 gap-6 mt-6">
        <x-cards.plain>
            <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
                Recent Advanced Training Registrations
            </div>
            <x-admin.table>
                <thead class="">
                    <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Course</th>
                        <th class="px-4 py-3">Registered</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-ot-steel">

                    @foreach ($recentTrainingRegistrations as $attendee)
                    <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                        <td class="px-4 py-1 font-medium">
                            @if($attendee->user)
                            <a class="" href="{{ route('admin.users.show', $attendee->user) }}">
                                {{ $attendee->user->name }}
                            </a>
                            @else
                            DELETED USER
                            @endif
                        </td>
                        <td class="px-4 py-1">
                            <a class="" href="{{ route('admin.training-course-attendees.show', [$attendee->trainingCourse->training, $attendee->trainingCourse, $attendee]) }}">
                                <div class="font-medium">{{ $attendee->trainingCourse->training->name }}</div>
                                <div class="text-xs">
                                    {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                                    {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                                </div>
                            </a>
                        </td>
                        <td class="px-4 py-1 whitespace-nowrap">
                            {{ $attendee->created_at->format('m/d/Y H:i:s') }}
                            <span class="text-otgray text-sm ml-2">({{ $attendee->created_at->diffForHumans() }})</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        </x-cards.plain>


        @if($birthdayUsers->isNotEmpty())
        <x-cards.plain>
            <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
                Upcoming Birthdays
            </div>
            <x-admin.table>
                <thead class="">
                    <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Birthday</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-ot-steel">

                    @foreach ($birthdayUsers as $user)
                    <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                        <td class="px-4 py-1 font-medium">
                            <a class="" href="{{ route('admin.users.show', $user) }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="px-4 py-1 text-xs">
                            @foreach($user->getRoleNames() as $role)
                            @if($role == 'Staff' || $role == 'Staff Instructor' || $role == 'Conference Instructor')
                            <div>{{ $role }}</div>
                            @endif
                            @endforeach
                        </td>
                        <td class="px-4 py-1">
                            {{ $user->profile->birthday->format('m/d/Y') }}

                            @php
                            if($user->profile->birthday >= now()) {
                            $line = 'Not born yet';
                            } else {

                            $date = $user->profile->birthday->diffForHumans();
                            $date = str_replace(' years ago', '', $date);

                            if(date('m-d', strtotime($user->profile->birthday)) == date('m-d')) {

                            $locale = 'en_US';
                            $nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
                            $line = 'Happy ' . $nf->format($date) . ' Birthday';

                            } else {
                            $date += 1;
                            $line = $date . ' years old';
                            }
                            }
                            @endphp
                            <span class="ml-2 {{ date('m-d', strtotime($user->profile->birthday)) == date('m-d') ? 'text-red-600 font-medium' : 'text-otgray text-sm' }}">{{ $line }}</span>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </x-admin.table>
        </x-cards.plain>
        @endif
    </div>




    @endcan

</x-app-layout>