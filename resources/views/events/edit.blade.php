<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.events.index') }}">Events</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</x-crumbs.a>
            Edit Event
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.events.update', $event) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Name" name="name" value="{!! $event->name !!}" class="mb-3" />
            <div class="flex gap-3">
                <x-fields.input-text label="Date" type="date" name="start_date" value="{{ $event->start_date->format('Y-m-d') }}" class="mb-3" required />
                <x-fields.input-text label="Start Time" type="time" name="start_time" value="{{ $event->start_date->format('H:i') }}" class="mb-3" required />
                <x-fields.input-text label="End Time" type="time" name="end_time" value="{{ $event->end_date->format('H:i') }}" class="mb-3" required />
                <x-fields.input-text label="Capacity" type="number" name="capacity" value="{{ $event->capacity }}" class="mb-3" />
            </div>

            <div class="flex gap-3">
                <x-fields.select class="mb-3" width="w-auto" label="Region" name="region" :selections="$regions" :selected="$event->region" placeholder=" " />
                <x-fields.select class="mb-3" width="w-auto" label="User" name="user_id" :selections="$users" :selected="$event->user_id" placeholder=" " />
                <x-fields.select class="mb-3" width="w-auto" label="Venue" name="venue_id" :selections="$venues" :selected="$event->venue_id" placeholder=" " />
                <div>
                    <x-label class="mb-3">
                        <div>Active</div>
                        <input class="ml-2 mt-2" type="checkbox" name="active" value="1" {{ $event->active ? 'checked' : '' }} />
                    </x-label>
                </div>
            </div>
            <div>
                <x-label for="description">Description</x-label>
                <x-textarea id="description" name="description" class="addTiny mb-3">{!! $event->description !!}</x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>