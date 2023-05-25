<x-site-layout>
    <div class="bg-otgold text-white">
        <div class="px-10 py-4 max-w-6xl mx-auto">
            <div class="font-semibold text-3xl font-blender text-center">
                Dashboard
            </div>
        </div>
    </div>


    <div class="bg-otsteel flex-1">
        <div class="lg:px-4 py-6 max-w-7xl mx-auto">


            <div class="flex">

                <x-dahboard-nav selected="staff-training-courses" />

                <div class="flex-1 bg-white p-6">



                    @role('Staff Instructor')
                    <div class="">
                        <h2 class="px-4 text-2xl font-semibold border-b border-otgray">Advanced Training Courses I'm Teaching</h2>
                        <div class="p-4 bg-otgray-100">
                            @if($instructorTrainingCourses->isNotEmpty())
                            @php
                            $currentTraining = 0;
                            @endphp
                            @foreach($instructorTrainingCourses as $course)
                            @if($course->training->id != $currentTraining)
                            <div class="font-semibold text-xl {{ $loop->index > 0 ? 'mt-4' : '' }}">{{ $course->training->name }}</div>
                            @php
                            $currentTraining = $course->training->id;
                            @endphp
                            @endif
                            <div>
                                <a href="{{ route('training-courses.show.instructor', $course) }}">
                                    {{ date('F j, Y', strtotime($course->start_date)) }} -
                                    {{ date('F j, Y', strtotime($course->end_date)) }}
                                </a>
                            </div>
                            @endforeach
                            @else
                            <div class="text-lg">
                                You are not scheduled to instruct any upcoming Conference courses.
                            </div>
                            @endif
                        </div>
                    </div>
                    @endrole


                </div>





            </div>
        </div>
    </div>


</x-site-layout>