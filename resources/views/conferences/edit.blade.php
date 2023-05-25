<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Edit Conference
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.plain class="lg:flex" x-data="{ tab: (localStorage.getItem('conference_tab') ? localStorage.getItem('conference_tab') : 'general') }">

        <div class="flex flex-wrap justify-items-center lg:block bg-otsteel-300 text-center lg:text-left">
            <x-tab-click item="conference_tab" tab="general">
                General Information
            </x-tab-click>
            <x-tab-click item="conference_tab" tab="courses">
                Courses
            </x-tab-click>
        </div>


        <div class="flex-1">

            <x-tab-card tab="general">

                <h2 class="text-2xl mb-4">General Information</h2>

                <x-form-errors />

                <form method="POST" id="main-form" x-data="slugHandler()" action="{{ route('admin.conferences.update', $conference) }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid xl:grid-cols-2 gap-3">
                        <div class="mb-3">
                            <x-label for="Name">Name</x-label>
                            <x-input id="name" name="name" x-model="name" @keyup="slugName" value="{{ $conference->name }}" />
                        </div>

                        <div class="mb-3">
                            <x-label for="Slug">Slug</x-label>
                            <x-input id="slug" name="slug" x-model="slug" value="{{ $conference->slug }}" />
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" :selected="$conference->venue_id" placeholder=" " />
                        <div class="mb-3">
                            <x-label for="price">Price</x-label>
                            <div class="dollar">
                                <x-input id="price" name="price" type="number" value="{{ $conference->price }}" />
                            </div>
                        </div>
                    </div>

                    <div class="hidden">
                        <x-fields.input-text label="Location" name="location" value="{{ $conference->location }}" class="mb-3" />
                        <x-fields.input-text label="Address" name="address" value="{{ $conference->address }}" class="mb-3" />

                        <div class="flex gap-3">
                            <x-fields.input-text label="City" name="city" value="{{ $conference->city }}" class="mb-3" />
                            <x-fields.input-text label="State" name="state" value="{{ $conference->state }}" class="mb-3" />
                            <x-fields.input-text label="Zip" name="zip" value="{{ $conference->zip }}" class="mb-3" />
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <x-fields.input-text label="Start Date" type="date" name="start_date" value="{{ $conference->start_date->toDateString() }}" class="mb-3" />
                        <x-fields.input-text label="End Date" type="date" name="end_date" value="{{ $conference->end_date->toDateString() }}" class="mb-3" />
                    </div>
                    <div class="flex gap-3">
                        <x-fields.input-text label="Vendor Start Date" type="date" name="vendor_start_date" value="{{ $conference->vendor_start_date ? $conference->vendor_start_date->toDateString() : '' }}" class="mb-3" />
                        <x-fields.input-text label="Vendor End Date" type="date" name="vendor_end_date" value="{{ $conference->vendor_end_date ? $conference->vendor_end_date->toDateString() : '' }}" class="mb-3" />
                    </div>
                    <div class="flex gap-3">
                        <x-fields.input-text label="Registration Start Date" type="date" name="registration_start_date" value="{{ $conference->registration_start_date ? $conference->registration_start_date->toDateString() : '' }}" class="mb-3" />
                        <x-fields.input-text label="Registration End Date" type="date" name="registration_end_date" value="{{ $conference->registration_end_date ? $conference->registration_end_date->toDateString() : '' }}" class="mb-3" />
                    </div>

                    <div>
                        <label class="flex gap-3 items-center mb-3">
                            <input type="checkbox" name="conference_visible" value="true" {{ $conference->conference_visible ? 'checked' : '' }} />
                            Conference Visible
                        </label>
                        <label class="flex gap-3 items-center mb-3">
                            <input type="checkbox" name="courses_visible" value="true" {{ $conference->courses_visible ? 'checked' : '' }} />
                            Courses Visible
                        </label>
                        <label class="flex gap-3 items-center mb-3">
                            <input type="checkbox" name="vendor_active" value="true" {{ $conference->vendor_active ? 'checked' : '' }} />
                            Vendor Registration Active
                        </label>
                        <label class="flex gap-3 items-center mb-3">
                            <input type="checkbox" name="registration_active" value="true" {{ $conference->registration_active ? 'checked' : '' }} />
                            Attendee Registration Active
                        </label>
                    </div>

                    <div class="mb-3">
                        <x-label>Description</x-label>
                        <x-textarea rows="5" class="addTiny" name="description">{{ $conference->description }}</x-textarea>
                    </div>

                    <script type="text/javascript">
                        function slugHandler() {
                        return {
                            name: '{{ $conference->name }}',
                            slug: '{{ $conference->slug }}',
                            slugName() {
                                // console.log(this.name);
                                this.slug = this.slugify(this.name);
                            },
                            slugify(text) {
                                return text
                                    .toString()                           // Cast to string (optional)
                                    .normalize('NFKD')            // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
                                    .toLowerCase()                  // Convert the string to lowercase letters
                                    .trim()                                  // Remove whitespace from both sides of a string (optional)
                                    .replace(/\s+/g, '-')            // Replace spaces with -
                                    .replace(/[^\w\-]+/g, '')     // Remove all non-word chars
                                    .replace(/\-\-+/g, '-');        // Replace multiple - with single -
                            }
                        }
                    }
                    </script>
                </form>


            </x-tab-card>

            <x-tab-card tab="courses">
                <h2 class="text-2xl mb-4">Courses</h2>

                @livewire('course-create', ['conference_id' => $conference->id, 'start_date' => $conference->start_date, 'end_date' => $conference->start_date])

            </x-tab-card>

        </div>
    </x-cards.plain>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>