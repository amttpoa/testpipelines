<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $course->conference) }}">{{ $course->conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.index', $course->conference) }}">Courses</x-crumbs.a>
            {{ $course->name}}
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.course-attendees.view-roster', [$course->conference, $course]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Attendees</a>
            <a href="{{ route('admin.course-attendees.pdf-roster', [$course->conference, $course]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank" download>PDF Attendees</a>
        </x-page-menu>
        <div>
            <x-button-link href="{{ route('admin.courses.edit', [$course->conference, $course]) }}">Edit Course</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <x-cards.main>
            <div class="flex gap-3 mb-4">
                <div class="flex-1">
                    <div class="text-2xl font-medium">
                        {{ $course->name }}
                    </div>
                    <div class="text-xl font-medium">
                        {{ $course->start_date->format('m/d/Y h:i')}} - {{ $course->end_date->format('h:i')}}
                    </div>

                </div>

                <div>
                    <a href="{{ route('course', [$course->conference, $course]) }}" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>

                @if($course->user)
                <div class="text-center w-40">
                    <a href="{{ route('admin.users.show', $course->user) }}">
                        <x-profile-image class="w-24 h-24 inline" :profile="$course->user->profile" />
                        <div class="text-xl font-medium">{{ $course->user->name }}</div>
                    </a>
                </div>
                @endif

                @if($course->users->isNotEmpty())
                <div class="">
                    @foreach($course->users as $user)
                    <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-3 mb-2">
                        <x-profile-image class="w-10 h-10" :profile="$user->profile" />
                        <div class="font-medium">{{ $user->name }}</div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>



            <div class="mb-3">
                @foreach($course->courseTags as $tag)
                <div class="text-sm inline-block mr-1 rounded-full bg-otgray px-2 text-white">{{ $tag->name }}</div>
                @endforeach
            </div>
            @if($course->venue)
            <div class="text-lg">
                <a href="{{ route('admin.venues.show', $course->venue) }}">{{ $course->venue->name }}</a>
            </div>
            @endif
            <div>
                {{ $course->location }}
            </div>

            <div class="mt-4 text-lg">
                <x-a href="{{ route('admin.course-attendees.index', [$course->conference, $course]) }}">
                    {{ $course->courseAttendees->count() }} Attendees
                </x-a>
            </div>
            <div>
                {{ $course->courseAttendees->where('checked_in')->count() }} Checked In
            </div>
            <div>
                {{ $course->courseAttendees->where('completed')->count() }} Completed
            </div>

            @foreach($course->surveys as $survey)
            <div>
                {{ $survey->user->name }}
            </div>
            @endforeach

            @foreach($answers as $question => $one)
            <div class="mt-4 font-medium text-xl">
                {{ $question }}
            </div>
            @foreach($one as $answer)
            <div>{{ $answer->answer }}</div>
            @endforeach
            @endforeach


        </x-cards.main>

        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\Course', 'subject_id' => $course->id])
        </x-cards.main>
    </div>

</x-app-layout>