<x-dashboard.layout>
    @section("pageTitle")
    Attendees
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.conferences.show', $conference) }}">{{ $conference->name }}</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.courses.index', $conference) }}">Courses</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.courses.show', [$conference, $course]) }}">{{ $course->name }}</a>
        <x-breadcrumbs.arrow />
        Attendees
    </x-breadcrumbs.holder>

    <div>
        <form method="POST" id="main-form" action="{{ route('dashboard.staff.course-attendees.updateBatch', [$conference, $course]) }}">
            @csrf
            @method('PATCH')

            @foreach($course->courseAttendees as $attendee)
            <div class="flex gap-3 items-center py-3 border-b border-otgray">
                <div>
                    <input type="checkbox" class="selectAll" name="attendee_id[]" value="{{ $attendee->id }}" />
                </div>
                <div class="w-20">
                    <x-profile-image class="w-20 h-20" :profile="$attendee->user->profile" />
                </div>
                <div class="flex-1">
                    <div class="lg:grid lg:grid-cols-4 lg:gap-4 items-center">
                        <div class="col-span-2">
                            <div class="text-2xl font-medium">{{ $attendee->user->name }}</div>
                            <div class="font-medium">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</div>
                            <div>
                                {{ $attendee->user->profile->phone }} &bull; {{ $attendee->user->email }}
                            </div>
                        </div>
                        <div class="text-sm text-center">
                            <div>
                                @if($attendee->checked_in)
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                                    <i class="fa-solid fa-check w-5 text-center"></i> Checked In
                                </div>
                                @else
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
                                    <i class="fa-solid fa-x w-5 text-center"></i> Not Checked In
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm text-center">
                            <div class="">
                                @if($attendee->completed)
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                                    <i class="fa-solid fa-check w-5 text-center"></i> Completed
                                </div>
                                @else
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
                                    <i class="fa-solid fa-x w-5 text-center"></i> Not Completed
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            @endforeach

            <div class="flex gap-3 items-center py-3 border-t border-otgray">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" value="" id="selectAll2" class="mr-2" />
                        select/deselect all
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <input type="hidden" name="type" id="markType" value="" />
                <x-button-site id="markCheck">Mark selected as Checked In</x-button-site>
                <x-button-site id="markCompleted">Mark selected as Completed</x-button-site>
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
        </form>
    </div>

    <x-dashboard.table class="hidden">
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Name</th>
            <th class="px-2 py-1">Organization</th>
            <th class="px-2 py-1">Email</th>
            <th class="px-2 py-1">Phone</th>
        </tr>

        @foreach($course->courseAttendees as $attendee)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1">{{ $attendee->user->name }}</td>
            <td class="px-2 py-1">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</td>
            <td class="px-2 py-1">{{ $attendee->user->email }}</td>
            <td class="px-2 py-1">{{ $attendee->user->profile->phone }}</td>
        </tr>
        @endforeach
    </x-dashboard.table>

</x-dashboard.layout>