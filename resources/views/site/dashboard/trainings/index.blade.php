<x-dashboard.layout>
    @section("pageTitle")
    Advanced Training
    @endSection

    <x-breadcrumbs.holder>
        Advanced Training
    </x-breadcrumbs.holder>


    <x-info-h> Advanced Training courses you are registered for</x-info-h>

    @if($trainingCourseAttendees->isEmpty())
    <div class="text-red-700 font-light mb-2">No courses registered</div>
    <div>
        Check out the <x-a href="{{ route('trainings') }}">Advanced Training</x-a> page to register for an upcoming course.
    </div>
    @else
    <div class="border-t border-otgray mb-2">
        @foreach($trainingCourseAttendees as $attendee)
        <a href="{{ route('dashboard.trainings.show', $attendee) }}" class="block border-b border-otgray py-4 lg:px-4">
            <div class="lg:flex lg:gap-3 lg:items-center">
                <div class="lg:flex-1">
                    <div class="font-medium text-2xl">
                        {{ $attendee->trainingCourse->training->name }}
                    </div>
                    <div class="lg:flex lg:gap-4 lg:items-center">
                        <div class="text-lg">
                            {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                            {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                        </div>
                        <div class="text-otgray text-sm">
                            {{ $attendee->trainingCourse->start_date->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="font-medium">
                    <div>{{ $attendee->trainingCourse->venue ? $attendee->trainingCourse->venue->name : ''}}</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif



</x-dashboard.layout>