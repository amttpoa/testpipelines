<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.index', $conference) }}">Courses</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.show', [$conference, $course]) }}">{{ $course->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.course-attendees.index', [$conference, $course]) }}">Attendees</x-crumbs.a>
            {{ $courseAttendee->user ? $courseAttendee->user->name : '' }}
        </x-crumbs.holder>

        <x-page-menu>
            <form method="POST" action="{{ route('admin.course-attendees.destroy',  [$conference, $course, $courseAttendee]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    @if($courseAttendee->user)
    <x-cards.user :user="$courseAttendee->user" type="Course Attendee" class="mb-6" />
    @else
    <x-cards.main class="mb-6">
        DELETED USER
    </x-cards.main>
    @endif

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\CourseAttendee', 'subject_id' => $courseAttendee->id])
        </x-cards.main>

        <x-cards.main>


            <form method="POST" id="main-form" action="{{ route('admin.course-attendees.update', [$course->conference, $course, $courseAttendee]) }}">
                @csrf
                @method('PATCH')
                <div class="flex gap-6">
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="checked_in" value="1" {{ $courseAttendee->checked_in ? 'checked' : '' }} />
                        Checked In
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="completed" value="1" {{ $courseAttendee->completed ? 'checked' : '' }} />
                        Completed
                    </label>
                </div>

                @if($courseAttendee->conferenceAttendee)
                <x-a href="{{ route('admin.conference-attendees.show', [$course->conference, $courseAttendee->conferenceAttendee]) }}">
                    Conference Attendee
                </x-a>
                @else
                Conference Attendee Deleted
                @endif

            </form>

        </x-cards.main>
    </div>

    <x-cards.main class="mt-6">

        @if($courseAttendee->surveyConferenceCourseSubmission)
        <h2 class="text-2xl mb-4">
            Survey
        </h2>
        @foreach($courseAttendee->surveyConferenceCourseSubmission->lines as $line)
        <div class="font-medium">
            {{ $line->question }}
        </div>
        <div class="mb-4">
            {{ $line->answer }}
        </div>
        @endforeach
        @endif

    </x-cards.main>

</x-app-layout>