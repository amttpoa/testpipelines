<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.trainings.show', $training) }}">{{ $training->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.training-courses.index', $training) }}">Courses</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.training-courses.show', [$training, $trainingCourse]) }}">{{ $trainingCourse->start_date->format('m/d/Y') }}</x-crumbs.a>
            Edit Course
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.training-courses.destroy',  [$training, $trainingCourse]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete Course</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main x-data="formHandler()">

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.training-courses.update', [$training, $trainingCourse]) }}">
            @csrf
            @method('PATCH')

            <div class="flex">

                <div class="flex-1">
                    <div class="flex gap-3">
                        <x-fields.input-text label="Start Date" type="date" name="start_date" value="{{ $trainingCourse->start_date->toDateString() }}" class="mb-3" />
                        <x-fields.input-text label="End Date" type="date" name="end_date" value="{{ $trainingCourse->end_date->toDateString() }}" class="mb-3" />
                        <x-fields.input-text label="Capacity" type="number" name="capacity" value="{{ $trainingCourse->capacity }}" class="mb-3" />
                        <x-fields.input-text label="Price" type="number" name="price" value="{{ $trainingCourse->price }}" class="mb-3" />
                    </div>

                    <div class="flex gap-3">
                        <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" :selected="$trainingCourse->venue_id" placeholder=" " />
                        <div class="mb-3">
                            <x-label for="visible">Visible</x-label>
                            <input class="ml-4" type="checkbox" name="visible" id="visible" value="true" {{ $trainingCourse->visible ? 'checked' : '' }} />
                        </div>
                        <div class="mb-3">
                            <x-label for="active">Active</x-label>
                            <input class="ml-4" type="checkbox" name="active" id="active" value="true" {{ $trainingCourse->active ? 'checked' : '' }} />
                        </div>
                        <div class="mb-3">
                            <x-label for="active_admin">Active Admin</x-label>
                            <input class="ml-4" type="checkbox" name="active_admin" id="active_admin" value="true" {{ $trainingCourse->active_admin ? 'checked' : '' }} />
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <x-fields.select class="mb-3" width="w-auto" label="Instructor" name="user_id" :selections="$instructors" :selected="$trainingCourse->user_id" placeholder=" " />

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


            <x-label>Description</x-label>
            <x-textarea rows="5" class="addTiny" name="description">{{ $trainingCourse->description }}</x-textarea>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

    <script type="text/javascript">
        function formHandler() {
            return {
                sponsorship_chosen: null,

                users: {!! $trainingCourse->users !!},
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