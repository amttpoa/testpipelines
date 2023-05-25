<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.index', $conference) }}">Courses</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.show', [$conference, $course]) }}">{{ $course->name }}</x-crumbs.a>
            Attendees
        </x-crumbs.holder>
    </x-crumbs.bar>

    <form method="POST" id="main-form" action="{{ route('admin.course-attendees.updateBatch', [$conference, $course]) }}">
        @csrf
        @method('PATCH')

        <x-cards.plain>

            <div class="overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="">
                            <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Organization</th>
                                <th class="px-4 py-3 text-center">Checked In</th>
                                <th class="px-4 py-3 text-center">Completed</th>
                                <th class="px-4 py-3 text-center">Survey</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-ot-steel">


                            @foreach ($courseAttendees as $attendee)
                            <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                <td class="px-4 py-3">
                                    <input type="checkbox" class="selectAll" name="attendee_id[]" value="{{ $attendee->id }}" />
                                </td>
                                <td class="px-4 py-3">
                                    <a class="flex gap-3 items-center" href="{{ route('admin.course-attendees.show', [$attendee->course->conference, $attendee->course, $attendee]) }}">
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
                                    <a href="{{ route('admin.organizations.show', $attendee->user->organization) }}">
                                        <div class="">{{ $attendee->user->organization->name }}</div>
                                        <div class="text-otsteel text-sm">{{ $attendee->user->organization->domain }}</div>
                                    </a>
                                    @endif
                                    @endif
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-4 py-3 border-t border-otsteel">
                <label class="inline-flex items-center justify-start">
                    <input type="checkbox" value="" id="selectAll2" class="mr-2" />
                    select/deselect all
                </label>
            </div>

            <script>
                $(document).ready(function() {
                    $('#markCheck').click(function() {
                        $('#markType').val('checkedin');
                    });
                    $('#markCompleted').click(function() {
                        $('#markType').val('completed');
                    });
                    $('#selectAll2').change(function() {
                        if($(this).is(":checked")) {
                            $('.selectAll').prop('checked', true);
                        } else {
                            $('.selectAll').prop('checked', false);
                        }      
                    });
                });
            </script>

            @if($courseAttendees->hasPages())
            <div class="p-4">
                {{ $courseAttendees->links() }}
            </div>
            @endif

        </x-cards.plain>

        <div class="flex gap-3 mt-6 ml-6">
            <input type="hidden" name="type" id="markType" value="" />
            <x-button id="markCheck">Mark selected as Checked In</x-button>
            <x-button id="markCompleted">Mark selected as Completed</x-button>
        </div>
    </form>

</x-app-layout>