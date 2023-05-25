<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conferenceAttendee->conference) }}">{{ $conferenceAttendee->conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-attendees.index', $conferenceAttendee->conference) }}">Attendees</x-crumbs.a>
            {{ $conferenceAttendee->user ? $conferenceAttendee->user->name : 'DELETED USER' }}
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.conference-attendees.edit', [$conferenceAttendee->conference, $conferenceAttendee]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Edit Attendee</a>

            <form method="POST" action="{{ route('admin.conference-attendees.destroy',  [$conferenceAttendee->conference, $conferenceAttendee]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
            <a href="{{ route('admin.conference-attendees.view-badge', [$conferenceAttendee->conference, $conferenceAttendee]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Badge</a>
            <a href="{{ route('admin.conference-attendees.pdf-badge', [$conferenceAttendee->conference, $conferenceAttendee]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank" download>PDF Badge</a>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>


    <div class="flex gap-6 mb-6">
        @if($conferenceAttendee->user)
        <x-cards.user :user="$conferenceAttendee->user" type="Conference Attendee" class="flex-1" />
        @endif
        <x-cards.main class="w-64 text-center">
            <div class="font-medium text-xl mb-3">Badge Info</div>
            <div class="">
                <div class="text-2xl font-medium">
                    {{ $conferenceAttendee->card_first_name }}
                </div>
                <div class="text-lg font-medium">
                    {{ $conferenceAttendee->card_last_name }}
                </div>
                <div class="mt-3">
                    {{ $conferenceAttendee->card_type }}
                </div>
            </div>
        </x-cards.main>
    </div>


    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\ConferenceAttendee', 'subject_id' => $conferenceAttendee->id])
        </x-cards.main>

        <x-cards.main>
            <form method="POST" id="main-form" action="{{ route('admin.conference-attendees.update', [$conferenceAttendee->conference, $conferenceAttendee]) }}">
                @csrf
                @method('PATCH')
                <div class="flex gap-6">
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="comp" value="1" {{ $conferenceAttendee->comp ? 'checked' : '' }} />
                        Full Comp
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="invoiced" value="1" {{ $conferenceAttendee->invoiced ? 'checked' : '' }} />
                        Invoiced
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="paid" value="1" {{ $conferenceAttendee->paid ? 'checked' : '' }} />
                        Paid
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="checked_in" value="1" {{ $conferenceAttendee->checked_in ? 'checked' : '' }} />
                        Checked In
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="completed" value="1" {{ $conferenceAttendee->completed ? 'checked' : '' }} />
                        Completed
                    </label>
                </div>
            </form>
            <h2 class="text-2xl mb-2">Payment Info</h2>
            <div class="font-medium">
                {{ $conferenceAttendee->package }} - ${{ $conferenceAttendee->total }}
            </div>
            <div>
                {{ $conferenceAttendee->pay_type }}
            </div>
            <div>
                {{ $conferenceAttendee->name }}
            </div>
            <div>
                {{ $conferenceAttendee->email }}
            </div>
            <div>
                {{ $conferenceAttendee->purchase_order }}
            </div>
            <div>
                {{ $conferenceAttendee->stripe_status }}
            </div>
            <div>
                Registered {{ $conferenceAttendee->created_at->format('m/d/Y H:i') }}
                @if($conferenceAttendee->registered_by_user_id)
                @if($conferenceAttendee->user_id != $conferenceAttendee->registered_by_user_id)
                by
                <x-a href="{{ route('admin.users.show', $conferenceAttendee->registeredByUser) }}">
                    {{ $conferenceAttendee->registeredByUser->name }}
                </x-a>
                @endif
                @endif
            </div>
            <div>
                @if($conferenceAttendee->checkedInByUser)
                Checked in {{ $conferenceAttendee->checked_in_at->format('m/d/Y H:i') }}
                by
                <x-a href="{{ route('admin.users.show', $conferenceAttendee->checkedInByUser) }}">
                    {{ $conferenceAttendee->checkedInByUser->name }}
                </x-a>
                @endif
            </div>
        </x-cards.main>
    </div>

    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Course</th>
                            <th class="px-4 py-3 text-center">Checked In</th>
                            <th class="px-4 py-3 text-center">Completed</th>
                            <th class="px-4 py-3 text-center">Survey</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">


                        @foreach($conferenceAttendee->courseAttendees->sortBy('course.start_date') as $attendee)
                        @if($attendee->course)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $attendee->course->start_date->format('m/d/Y') }}
                                {{ $attendee->course->start_date->format('H:i') }} - {{ $attendee->course->end_date->format('H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <a class="font-medium" href="{{ route('admin.course-attendees.show', [$attendee->course->conference, $attendee->course, $attendee]) }}">
                                    {{ $attendee->course->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($attendee->checked_in)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($attendee->completed)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($attendee->surveyConferenceCourseSubmission)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>

                        </tr>
                        @else
                        <tr>
                            <td>DELETED COURSE</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </x-cards.plain>

</x-app-layout>