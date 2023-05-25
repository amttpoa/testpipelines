<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.trainings.show', $training) }}">{{ $training->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.training-courses.index', $training) }}">Courses</x-crumbs.a>
            Create Course
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.training-courses.store', $training) }}">
            @csrf

            <div class="flex gap-3" x-data="dateHandler">
                <div class="mb-3">
                    <x-label for="start_date">Start Date</x-label>
                    <x-input id="start_date" type="date" name="start_date" @change="addEnd" x-model="start_date" />
                </div>
                <div class="mb-3">
                    <x-label for="end_date">End Date</x-label>
                    <x-input id="end_date" type="date" name="end_date" x-model="end_date" />
                </div>
                <x-fields.input-text label="Capacity" type="number" name="capacity" class="mb-3" />
                <x-fields.input-text label="Price" type="number" name="price" value="{{ !empty($training) ? $training->price : '' }}" class="mb-3" />
            </div>
            <script type="text/javascript">
                function dateHandler() {
                    return {
                        
                        start_date: null,
                        end_date: null,
                        addEnd() {
                            if (this.end_date == null) {
                                this.end_date = this.start_date;
                            }
                        },
                    }
                }
            </script>

            <div class="flex gap-3">
                <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" placeholder=" " />
                <x-fields.select class="mb-3" width="w-auto" label="Instructor" name="user_id" :selections="$instructors" placeholder=" " />
                <div class="mb-3">
                    <x-label for="visible">Visible</x-label>
                    <input type="checkbox" name="visible" id="visible" value="true" />
                </div>
                <div class="mb-3">
                    <x-label for="active">Active</x-label>
                    <input type="checkbox" name="active" id="active" value="true" />
                </div>
            </div>
            <x-textarea rows="5" class="addTiny" name="description"></x-textarea>

        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>