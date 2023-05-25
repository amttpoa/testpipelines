<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.events.index') }}">Events</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.events.show', $event) }}">{{ $eventAttendee->event->name }}</x-crumbs.a>
            {{ $eventAttendee->user->name }}
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.event-attendees.destroy',  [$event, $eventAttendee]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <x-cards.user :user="$eventAttendee->user" />
        <x-cards.main>
            <form method="POST" id="main-form" action="{{ route('admin.event-attendees.update', [$event, $eventAttendee]) }}">
                @csrf
                @method('PATCH')
                <x-fields.input-text label="Comments" name="comments" class="mb-4" value="{!! $eventAttendee->comments !!}" />
                <div class="flex gap-6">
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="checked_in" value="1" {{ $eventAttendee->checked_in ? 'checked' : '' }} />
                        Checked In
                    </label>
                </div>
            </form>
        </x-cards.main>
    </div>

</x-app-layout>