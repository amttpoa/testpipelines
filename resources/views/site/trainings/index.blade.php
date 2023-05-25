<x-site-layout>
    @section("pageTitle")
    Advanced Training
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-3xl lg:text-6xl">Advanced Training</div>
    </x-banner>

    <section class="bg-otsteel border-b py-8 flex-1">

        @foreach($trainings as $training)
        <div class="max-w-6xl mx-auto bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-4 md:px-6 py-2 text-center md:text-left">
                <a href="{{ route('training', $training->slug) }}" class="text-3xl md:text-4xl font-bold font-blender">{{ $training->name }}</a>

            </div>
            <div>
                <div class="p-4 md:p-6">
                    <div class="md:float-right md:ml-6 mb-6">
                        <div class="text-center px-4">
                            <div class="font-medium">{{ $training->days }} Days</div>
                            <div class="text-5xl font-blender font-bold">${{ $training->price }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="prose max-w-full">{!! $training->short_description !!}</div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('training', $training->slug) }}" class="text-xl text-otgold font-semibold">View full course description</a>
                    </div>
                </div>


                @if($training->upcomingCourses->isEmpty())
                <div class="px-4 md:px-6 py-2 text-red-200 bg-red-800 text-lg">There are currently no upcoming {{ $training->name }} courses available.</div>
                @else

                <div class="hidden md:flex items-center text-sm font-medium text-white bg-otgray divide-x divide-white">
                    <div class="hidden md:flex flex-1 items-center text-sm font-medium text-white bg-otgray divide-x divide-white">
                        <div class="md:w-72 px-4 py-3">Dates</div>
                        <div class="md:flex-1 px-4 py-3">Venue</div>
                        <div class="md:w-60 px-4 py-3">Instructor</div>
                    </div>
                    <div class="md:w-32 px-4 py-3 text-center">Register</div>
                </div>
                @foreach($training->upcomingCourses as $course)
                <a href="{{ route('trainingCourse', [$training, $course]) }}">
                    <div class="font-medium px-4 py-2 md:p-0 flex items-center border-t border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }} hover:bg-otgray-200">
                        <div class="flex-1 block md:flex md:items-center">
                            <div class="block md:w-72 md:px-4 pb-1 md:py-3 text-lg font-medium">
                                {{ date('m/d/Y', strtotime($course->start_date)) }}
                                - {{ date('m/d/Y', strtotime($course->end_date)) }}
                            </div>
                            <div class="block md:flex-1 md:px-4 pb-1 md:py-3">
                                @if($course->venue)
                                {{ $course->venue->name }}
                                @endif
                            </div>
                            <div class="block md:w-60 md:px-4 md:py-3">
                                @if($course->user)
                                <div class="flex gap-2 items-center">
                                    <x-profile-image class="w-8 h-8" :profile="$course->user->profile" />
                                    <div>{{ $course->user->name }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="w-20 md:w-32 text-center">
                            @if((!$course->active) && ($course->capacity > $course->attendees->count()))
                            Resticted
                            @elseif($course->attendees->count() >= $course->capacity)
                            Full
                            @else

                            @auth
                            @if(auth()->user()->trainingCourseAttendees->where('training_course_id', $course->id)->first() && !auth()->user()->can('organization-admin'))
                            <div class="font-semibold">Registered</div>
                            @else
                            <div class="text-otgold font-medium">
                                Register
                            </div>
                            @endif
                            @endauth

                            @guest
                            <div class="text-otgold font-medium">
                                Register
                            </div>
                            @endguest

                            @endif
                            <div class="text-xs text-otgray font-light">
                                {{ $course->attendees->count() }}/{{ $course->capacity }} filled
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach

                @endif


            </div>

        </div>
        @endforeach

    </section>

</x-site-layout>