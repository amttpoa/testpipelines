<x-site-layout>
    @section("pageTitle")
    {{ $user->name }} | Staff
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('staff') }}">Staff</a></div>
        <div class="text-3xl lg:text-6xl">{{ $user->name }}</div>
    </x-banner>


    <section class="flex-1 bg-otsteel">


        <div class="max-w-7xl h-full mx-auto bg-white shadow">

            <div class="lg:flex">

                <div class="lg:w-84 bg-otgray-200 p-6 text-center">
                    <div class="sticky top-10">
                        <div class="w-full ">
                            <x-profile-image class="w-72 inline" :profile="$user->profile" />
                        </div>
                        <h3 class="text-3xl font-medium">
                            {{ $user->name }}
                        </h3>
                        <div class="text-otsteel text-xl">
                            {{ $user->profile->title }}
                        </div>
                    </div>
                </div>

                <div class="flex-1 p-4 md:p-6">

                    <h2 class="text-2xl font-medium mb-4">{{ $user->name }} Bio</h2>
                    <div class="prose max-w-full mb-8">
                        @if($user->profile->bio)
                        {!! $user->profile->bio !!}
                        @else
                        {{ $user->name }} has not provided a bio yet.
                        @endif
                    </div>



                    @if($courses->isNotEmpty())
                    <x-info-h class="px-4 mt-8">Upcoming conference courses {{ $user->name }} is teaching</x-info-h>
                    <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
                        @foreach($courses as $course)
                        <a href="{{ route('course', [$course->conference, $course]) }}" class="block border-b border-otgray py-4 px-4">
                            <div class="lg:flex lg:gap-3 lg:items-center">
                                <div class="lg:flex-1">
                                    <div class="font-medium text-2xl">
                                        {{ $course->name }}
                                    </div>
                                    <div class="lg:flex lg:gap-4 lg:items-center">
                                        <div class="text-lg">
                                            {{ $course->start_date->format('m/d/Y') }}
                                        </div>
                                        <div class="text-otgray text-sm">
                                            {{ $course->start_date->format('H:i') }} -
                                            {{ $course->end_date->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="font-medium">
                                    <div>{{ $course->venue ? $course->venue->name : ''}}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif




                    @if($trainingCourses->isNotEmpty())
                    <x-info-h class="px-4 mt-8">Upcoming advanced training courses {{ $user->name }} is teaching</x-info-h>
                    <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
                        @foreach($trainingCourses as $trainingCourse)
                        <a href="{{ route('trainingCourse', [$trainingCourse->training, $trainingCourse]) }}" class="block border-b border-otgray py-4 px-4">
                            <div class="lg:flex lg:gap-3 lg:items-center">
                                <div class="lg:flex-1">
                                    <div class="font-medium text-2xl">
                                        {{ $trainingCourse->training->name }}
                                    </div>
                                    <div class="lg:flex lg:gap-4 lg:items-center">
                                        <div class="text-lg">
                                            {{ $trainingCourse->start_date->format('m/d/Y') }} -
                                            {{ $trainingCourse->end_date->format('m/d/Y') }}
                                        </div>
                                        <div class="text-otgray text-sm">
                                            {{ $trainingCourse->start_date->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="font-medium">
                                    <div>{{ $trainingCourse->venue ? $trainingCourse->venue->name : ''}}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif






                    @if($trainingCoursesGrouped->isNotEmpty() && 1==2)
                    <h2 class="text-2xl font-medium">Upcoming training courses {{ $user->name }} is teaching</h2>
                    <div class="overflow-hidden w-full">
                        <div class="overflow-x-auto w-full">
                            @foreach($trainingCoursesGrouped as $index => $training)
                            <table class="w-full whitespace-no-wrap">
                                <tr>
                                    <td class="text-lg font-medium pt-4" colspan="4">{{ $index }}</td>
                                </tr>
                                <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
                                    <th class="px-2 py-1">Date</th>
                                    <th class="px-2 py-1">Venue</th>
                                </tr>

                                @foreach($training as $course)
                                <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
                                    <td class="px-2 py-1"><a href="{{ route('trainingCourse', [$course->training, $course]) }}" class="whitespace-nowrap">{{ $course->start_date->format('F j, Y') }} - {{ $course->end_date->format('F j, Y') }}</a></td>
                                    <td class="px-2 py-1">
                                        @if($course->venue)
                                        <a href="{{ route('venue', $course->venue) }}" class="">{{ $course->venue->name }}</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

            </div>

        </div>

    </section>

</x-site-layout>