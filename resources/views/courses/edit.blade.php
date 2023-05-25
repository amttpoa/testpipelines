<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $course->conference) }}">{{ $course->conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.index', $course->conference) }}">Courses</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.courses.show', [$course->conference, $course]) }}">{{ $course->name}}</x-crumbs.a>
            Edit Course
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.courses.destroy',  [$conference, $course]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main x-data="formHandler()">


        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.courses.update', [$course->conference, $course]) }}">
            @csrf
            @method('PATCH')

            <div class="flex gap-3">
                <div class="flex-1">
                    <x-fields.input-text label="Name" name="name" value="{!! $course->name !!}" class="mb-3" />
                    <div class="flex gap-3">
                        <x-fields.input-text label="Start Date" type="date" name="start_date" value="{{ explode(' ', $course->start_date)[0] }}" class="mb-3" />
                        <x-fields.input-text label="Start Time" type="time" name="start_time" value="{{ explode(' ', $course->start_date)[1] }}" class="mb-3" />
                        <x-fields.input-text label="End Date" type="date" name="end_date" value="{{ explode(' ', $course->end_date)[0] }}" class="mb-3" />
                        <x-fields.input-text label="End Time" type="time" name="end_time" value="{{ explode(' ', $course->end_date)[1] }}" class="mb-3" />
                        <x-fields.input-text label="Capacity" type="number" name="capacity" value="{{ $course->capacity }}" class="mb-3" />
                        <div>
                            <x-label class="mb-3">
                                <div>No Civilians</div>
                                <input class="ml-2 mt-2" type="checkbox" name="restricted" value="1" {{ $course->restricted ? 'checked' : '' }} />
                            </x-label>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" :selected="$course->venue_id" placeholder=" " />
                        <x-fields.input-text label="Location" name="location" value="{{ $course->location }}" class="mb-3 flex-1" />
                    </div>
                    <x-fields.select class="mb-3" width="w-auto" label="Link To" name="link_id" :selections="$parentCourses" :selected="$course->link_id" placeholder=" " />

                </div>

                <div class="mb-3">
                    <x-fields.select class="mb-3" width="w-auto" label="Instructor" name="user_id" :selections="$instructors" :selected="$course->user_id" placeholder=" " />

                    <template x-for="(attendee, index) in users" :key="index">
                        <div>
                            <x-fields.select class="mb-3" width="w-auto" xmodel="attendee.id" label="Instructor" name="user_ids[]" :selections="$instructors" placeholder=" " />
                        </div>
                    </template>
                    <div>
                        <x-button type="button" @click.prevent="addInstructor();">Add Another Instructor</x-button>
                    </div>
                </div>
            </div>

            <div class="mb-2">
                <x-label for="course_tag_ids[]">Tags</x-label>
                <div class="columns-3 inline-block">
                    @foreach($courseTags as $tag)
                    <label class="flex gap-3 items-center mb-3">
                        {{-- <input type="checkbox" name="course_tag_ids[]" value="{{ $tag->id }}" {{ in_array($role, $userRole) ? 'checked' : '' }} /> --}}
                        <input type="checkbox" name="course_tag_ids[]" value="{{ $tag->id }}" {{ $course->courseTags->contains('id', $tag->id) ? 'checked' : '' }} />
                        {{-- if($collection->contains('product_id',1234)) --}}
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <x-label for="instructor_requests">Instructor Requests</x-label>
                <x-textarea rows="5" name="instructor_requests" id="instructor_requests">{{ $course->instructor_requests }}</x-textarea>
            </div>
            <div class="mb-3">
                <x-label for="description">Course Description</x-label>
                <x-textarea rows="5" class="addTiny" name="description" id="description">{{ $course->description }}</x-textarea>
            </div>
            <div class="mb-3">
                <x-label for="requirements">Student Requirements</x-label>
                <x-textarea rows="5" class="addTiny" name="requirements" id="requirements">{{ $course->requirements }}</x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

    <script type="text/javascript">
        function formHandler() {
            return {
                sponsorship_chosen: null,

                users: {!! $course->users !!},
                instructors: [],
                company_name: null,
                company_website: null,


                addInstructor() {
                    // console.log('adding attendee');

                    this.users.push({
                        // open:false,
                       
                    });
                },
                removeAttendee(index) {
                    this.attendees.splice(index, 1);
                    this.lunchSelector = null;
                    this.lunch.name = null;    
                    this.lunch.price = null;
                    this.updateTotal();
                },  

            }
        }
    </script>
</x-app-layout>