<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.index', $conference) }}">Courses</x-crumbs.a>
            Create Course
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.courses.store', $conference) }}">
            @csrf

            <x-fields.input-text label="Name" name="name" value="" class="mb-3" required />
            <div class="flex gap-3">
                <x-fields.input-text label="Start Date" type="date" name="start_date" value="{{ explode(' ', $conference->start_date)[0] }}" class="mb-3" required />
                <x-fields.input-text label="Start Time" type="time" name="start_time" value="" class="mb-3" required />
                <x-fields.input-text label="End Date" type="date" name="end_date" value="{{ explode(' ', $conference->start_date)[0] }}" class="mb-3" required />
                <x-fields.input-text label="End Time" type="time" name="end_time" value="" class="mb-3" required />
                <x-fields.input-text label="Capacity" type="number" name="capacity" value="" class="mb-3" />
            </div>

            <div class="flex gap-3">
                <x-fields.select class="mb-3" width="w-auto" label="Instructor" name="user_id" :selections="$instructors" placeholder=" " />

                <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" placeholder=" " />
                <x-fields.input-text label="Location" name="location" class="mb-3 flex-1" />
            </div>
            <x-fields.select class="mb-3" width="w-auto" label="Link To" name="link_id" :selections="$parentCourses" placeholder=" " />

            <div class="mb-3">
                <x-label for="description">Course Description</x-label>
                <x-textarea rows="5" class="addTiny" name="description" id="description"></x-textarea>
            </div>
            <div class="mb-3">
                <x-label for="requirements">Student Requirements</x-label>
                <x-textarea rows="5" class="addTiny" name="requirements" id="requirements"></x-textarea>
            </div>
            <div class="mb-3">
                <x-label for="instructor_requests">Instructor Requests</x-label>
                <x-textarea rows="5" name="instructor_requests" id="instructor_requests"></x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>