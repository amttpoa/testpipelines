<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.trainings.show', $training) }}">{{ $training->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.training-courses.index', $training) }}">Courses</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.training-courses.show', [$training, $trainingCourse]) }}">{{ $trainingCourse->start_date->format('m/d/Y') }}</x-crumbs.a>
            {{ $trainingCourseAttendee->user ? $trainingCourseAttendee->user->name : 'DELETED USER' }}
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.training-course-attendees.edit', [$trainingCourseAttendee->trainingCourse->training, $trainingCourseAttendee->trainingCourse, $trainingCourseAttendee]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Edit Attendee</a>
            <form method="POST" action="{{ route('admin.training-course-attendees.destroy',  [$trainingCourseAttendee->trainingCourse->training, $trainingCourseAttendee->trainingCourse, $trainingCourseAttendee]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete Attendee</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    @if($trainingCourseAttendee->user)
    <x-cards.user :user="$trainingCourseAttendee->user" type="Advanced Training Attendee" class="flex-1 mb-6" />
    @else
    DELETED USER
    @endif

    <div class="grid md:grid-cols-2 gap-6 mb-6">

        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\TrainingCourseAttendee', 'subject_id' => $trainingCourseAttendee->id])
        </x-cards.main>

        <x-cards.main>

            <form method="POST" id="main-form" action="{{ route('admin.training-course-attendees.update', [$trainingCourseAttendee->trainingCourse->training, $trainingCourseAttendee->trainingCourse, $trainingCourseAttendee]) }}">
                @csrf
                @method('PATCH')
                <div class="flex gap-6">
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="comp" value="1" {{ $trainingCourseAttendee->comp ? 'checked' : '' }} />
                        Full Comp
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="invoiced" value="1" {{ $trainingCourseAttendee->invoiced ? 'checked' : '' }} />
                        Invoiced
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="paid" value="1" {{ $trainingCourseAttendee->paid ? 'checked' : '' }} />
                        Paid
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="checked_in" value="1" {{ $trainingCourseAttendee->checked_in ? 'checked' : '' }} />
                        Checked In
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="completed" value="1" {{ $trainingCourseAttendee->completed ? 'checked' : '' }} />
                        Completed
                    </label>
                </div>
            </form>

            <h2 class="text-2xl mb-2">Payment Info</h2>
            <div class="font-medium">
                ${{ $trainingCourseAttendee->total }}
            </div>
            <div>
                {{ $trainingCourseAttendee->pay_type }}
            </div>
            <div>
                {{ $trainingCourseAttendee->name }}
            </div>
            <div>
                {{ $trainingCourseAttendee->email }}
            </div>
            <div>
                {{ $trainingCourseAttendee->purchase_order }}
            </div>
            <div>
                {{ $trainingCourseAttendee->stripe_status }}
            </div>
            <div>
                Registered {{ $trainingCourseAttendee->created_at->format('m/d/Y') }}
                @if($trainingCourseAttendee->user_id != $trainingCourseAttendee->registered_by_user_id)
                by
                <x-a href="{{ route('admin.users.show', $trainingCourseAttendee->registeredByUser) }}">
                    {{ $trainingCourseAttendee->registeredByUser->name }}
                </x-a>
                @endif
            </div>
            <div>
                {{ $trainingCourseAttendee->notes }}
            </div>
        </x-cards.main>
    </div>


    @if($trainingCourseAttendee->surveyTrainingCourseSubmission)
    <x-cards.main class="">
        <h2 class="text-2xl mb-4">
            Survey
        </h2>
        @foreach($trainingCourseAttendee->surveyTrainingCourseSubmission->lines as $line)
        <div class="font-medium">
            {{ $line->question }}
        </div>
        <div class="mb-4">
            {{ $line->answer }}
        </div>
        @endforeach
    </x-cards.main>
    @endif


</x-app-layout>