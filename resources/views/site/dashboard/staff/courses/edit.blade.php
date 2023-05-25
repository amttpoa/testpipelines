<x-dashboard.layout>
    @section("pageTitle")
    Edit Course
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.conferences.show', $conference) }}">{{ $conference->name }}</a>
        <x-breadcrumbs.arrow />
        {{-- <a class="text-black" href="{{ route('dashboard.staff.courses.index', $conference) }}">Courses</a>
        <x-breadcrumbs.arrow /> --}}
        <a class="text-black" href="{{ route('dashboard.staff.courses.show', [$conference, $course]) }}">{{ $course->name }}</a>
        <x-breadcrumbs.arrow />
        Edit Course
    </x-breadcrumbs.holder>

    <x-info-h>
        Edit course description and requirements
    </x-info-h>

    <x-form-errors />

    <form method="POST" id="main-form" action="{{ route('dashboard.staff.courses.update', [$conference, $course]) }}">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <x-label for="instructor_requests">Instructor Requests</x-label>
            <x-textarea class="" rows="5" name="instructor_requests">{{ $course->instructor_requests }}</x-textarea>
        </div>

        <div class="mb-4">
            <x-label for="description">Course Description</x-label>
            <x-textarea class="addTiny" rows="5" name="description">{{ $course->description }}</x-textarea>
        </div>

        <div>
            <x-label for="requirements">Student Requirements</x-label>
            <x-textarea class="addTiny" rows="5" name="requirements">{{ $course->requirements }}</x-textarea>
        </div>

        <div class="mt-4">
            <x-button-site form="main-form">Save</x-button-site>
        </div>
    </form>



</x-dashboard.layout>