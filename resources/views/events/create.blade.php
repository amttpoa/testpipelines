<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.events.index') }}">Events</x-crumbs.a>
            Create Event
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.events.store') }}">
            @csrf

            <x-fields.input-text label="Name" name="name" class="mb-3" />
            <div class="flex gap-3">
                <x-fields.input-text label="Date" type="date" name="start_date" value="" class="mb-3" required />
                <x-fields.input-text label="Start Time" type="time" name="start_time" value="" class="mb-3" required />
                <x-fields.input-text label="End Time" type="time" name="end_time" value="" class="mb-3" required />
                <x-fields.input-text label="Capacity" type="number" name="capacity" value="" class="mb-3" />
            </div>

            <div class="flex gap-3">
                <x-fields.select class="mb-3" width="w-auto" label="Region" name="region" :selections="$regions" placeholder=" " />
                <x-fields.select class="mb-3" width="w-auto" label="User" name="user_id" :selections="$users" placeholder=" " />
                <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" placeholder=" " />
                <div>
                    <x-label class="mb-3">
                        <div>Active</div>
                        <input class="ml-2 mt-2" type="checkbox" name="active" value="1" />
                    </x-label>
                </div>
            </div>
            <div>
                <x-label for="description">Description</x-label>
                <x-textarea id="description" name="description" class="addTiny mb-3"></x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>