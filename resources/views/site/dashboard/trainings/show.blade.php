<x-dashboard.layout>
    @section("pageTitle")
    {{ $trainingCourseAttendee->trainingCourse->training->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.trainings.index') }}">Advanced Training</a>
        <x-breadcrumbs.arrow />
        {{ $trainingCourseAttendee->trainingCourse->training->name }}
    </x-breadcrumbs.holder>

    <div class="font-medium text-2xl">{{ $trainingCourseAttendee->trainingCourse->training->name }}</div>
    <div>
        {{ $trainingCourseAttendee->trainingCourse->start_date->format('m/d/Y') }} -
        {{ $trainingCourseAttendee->trainingCourse->end_date->format('m/d/Y') }}
    </div>


    <div class="font-medium">
        @if($trainingCourseAttendee->completed)

        @if($trainingCourseAttendee->surveyTrainingCourseSubmission)
        <div class="text-otgray">
            Survey Complete
        </div>
        <x-a href="{{ route('dashboard.trainings.certificate', $trainingCourseAttendee) }}">
            Download Certificate
        </x-a>
        @else
        <x-a href="{{ route('dashboard.trainings.survey', $trainingCourseAttendee) }}">
            Complete Survey
        </x-a>
        <div class="text-otgray text-xs font-light">
            To Download Certificate
        </div>
        @endif

        @else
        <div class="text-otgray">
            Course Not Completed
        </div>
        @endif

    </div>


</x-dashboard.layout>