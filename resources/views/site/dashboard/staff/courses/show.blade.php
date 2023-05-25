<x-dashboard.layout>
    @section("pageTitle")
    {{ $course->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.conferences.show', $conference) }}">{{ $conference->name }}</a>
        {{--
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.courses.index', $conference) }}">Courses</a> --}}
        <x-breadcrumbs.arrow />
        {{ $course->name }}

    </x-breadcrumbs.holder>


    <div class="md:flex md:gap-3">
        <div class="md:flex-1 mb-8">

            <div class="font-medium text-2xl">
                {{ $course->conference->name }}
            </div>
            <div class="text-2xl">
                {{ $course->name }}
            </div>
            <div class="lg:flex lg:gap-4 lg:items-center mb-4">
                <div class="text-lg">
                    {{ $course->start_date->format('m/d/Y') }}
                </div>
                <div class="text-otgray text-sm">
                    {{ $course->start_date->format('h:i') }} - {{ $course->end_date->format('h:i') }}
                </div>
            </div>

            <div>
                <x-a href="{{ route('dashboard.staff.courses.edit', [$conference, $course]) }}">
                    Edit course description and student requirements
                </x-a>
            </div>
        </div>

        <div class="md:w-56 mb-8">
            <div class="font-medium text-lg md:text-center mb-2">Instructor(s)</div>
            @if($course->user)
            <div class="mb-2">
                <a href="{{ route('staffProfile', $course->user) }}" class="flex gap-2 items-center">
                    <x-profile-image class="w-12 h-12" :profile="$course->user->profile" />
                    <div class="font-medium">
                        {{ $course->user->name }}
                    </div>
                </a>
            </div>
            @endif
            @foreach($course->users as $user)
            <div class="mb-2">
                <a href="{{ route('staffProfile', $user) }}" class="flex gap-2 items-center">
                    <x-profile-image class="w-12 h-12" :profile="$user->profile" />
                    <div class="font-medium">
                        {{ $user->name }}
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>


    <form method="POST" id="main-form" action="{{ route('dashboard.staff.course-attendees.updateBatch', [$conference, $course]) }}">
        @csrf
        @method('PATCH')

        <x-info-h>
            Course attendees
        </x-info-h>

        <div class="border-t border-otgray">
            @foreach($course->courseAttendees as $attendee)
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 items-center border-b border-otgray py-4">
                <div class="col-span-2 flex gap-3 items-center">
                    <div>
                        <input type="checkbox" class="selectAll" name="attendee_id[]" value="{{ $attendee->id }}" />
                    </div>
                    @if($attendee->user)
                    <div class="w-20">
                        <x-profile-image class="w-20 h-20" :profile="$attendee->user->profile" />
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-medium">{{ $attendee->user->name }}</div>
                        <div class="font-medium">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</div>
                        <div>
                            {{ $attendee->user->profile->phone }} &bull; {{ $attendee->user->email }}
                        </div>
                    </div>
                    @else
                    <div>DELETED USER</div>
                    @endif
                </div>

                <div class="">
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
                </div>
                <div>
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
            @endforeach
        </div>

        <div class="flex gap-3 items-center py-3">
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



    <div class="hidden">

        <div class="grid sm:grid-cols-3 gap-6 items-center mb-6">

            <a href="{{ route('dashboard.staff.course-attendees.index', [$conference, $course]) }}">
                <div class="flex gap-4 items-center">
                    <div class="">
                        <div class="border border-otsteel rounded-full bg-otsteel-100 overflow-hidden p-4">
                            <x-icons.users class="w-10 h-10 text-otsteel" />
                        </div>
                    </div>
                    <div>
                        <div class="font-medium text-2xl leading-tight">
                            {{ $course->courseAttendees->count() }} Attendees
                        </div>
                        <div class="text-lg leading-tight">
                            {{ $course->courseAttendees->where('checked_id')->count() }} Checked In
                        </div>
                        <div class="text-lg leading-tight">
                            {{ $course->courseAttendees->where('completed')->count() }} Complete
                        </div>
                    </div>
                </div>
            </a>

        </div>



        <div class="font-medium text-2xl">
            Course Description
        </div>

        @if($course->description)
        <div class="max-w-full prose">
            {!! $course->description !!}
        </div>
        @else
        <div class="text-red-800 font-medium">
            This is no course description.
            Please add a course description <x-a href="{{ route('dashboard.staff.courses.edit', [$conference, $course]) }}">here</x-a>.
        </div>
        @endif

        <div class="font-medium text-2xl mt-4">
            Student Requirements
        </div>
        @if($course->requirements)
        <div class="max-w-full prose">
            {!! $course->requirements !!}
        </div>
        @else
        <div class="text-red-800 font-medium">
            This are no student requirements.
            Please add student requirements <x-a href="{{ route('dashboard.staff.courses.edit', [$conference, $course]) }}">here</x-a>.
        </div>
        @endif

        <div class="mt-4">
            <x-a href="{{ route('dashboard.staff.courses.edit', [$conference, $course]) }}">
                Edit Course Description and Student Requirements
            </x-a>
        </div>


        @if($course->venue)
        <div class="mt-4 font-medium text-2xl">
            Venue
        </div>
        <div>
            <x-a href="{{ route('venue', $course->venue) }}">{{ $course->venue->name }}</x-a>
        </div>
        <div>
            {{ $course->venue->address }}<br>
            {{ $course->venue->city }}, {{ $course->venue->state }} {{ $course->venue->zip }}
        </div>
        @endif

    </div>


</x-dashboard.layout>