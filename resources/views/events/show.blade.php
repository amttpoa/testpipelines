<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.events.index') }}">Events</x-crumbs.a>
            {{ $event->name }}
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.events.export', $event) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank" download>Export Attendees</a>
        </x-page-menu>
        <div>
            <x-button-link href="{{ route('admin.events.edit', $event) }}">Edit Event</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <x-cards.main class="">
            <div>
                <div class="text-2xl font-medium">{{ $event->name }}</div>
                <div class="text-lg font-medium">
                    <span class="font-medium">{{ $event->start_date->format('m/d/Y') }}</span>
                    <span class="text-otgray ml-3">
                        {{ $event->start_date->format('H:i') }} -
                        {{ $event->end_date->format('H:i') }}
                    </span>
                </div>
                <div class="text-otgray text-sm">{{ $event->region ? 'Region ' . $event->region : '' }}</div>
            </div>
            <div>
                @if($event->venue)
                <div class="font-medium text-lg">{{ $event->venue->name }}</div>
                @endif
                @if($event->user)
                <div>
                    Hosted by:
                    <x-a href="{{ route('admin.users.show', $event->user) }}">{{ $event->user->name }}</x-a>
                </div>
                @endif
            </div>
            <div class="font-medium text-xl mb-4">
                {{ $event->active ? '' : 'NOT'}} Active
            </div>

            <form method="POST" action="{{ route('admin.event-attendees.add-attendee', $event) }}">
                @csrf
                <div>
                    @livewire('user-autocomplete', ['user_id' => '', 'user_name' => ''] )
                </div>
                <div class="mt-4">
                    <x-button>Add Attendee</x-button>
                </div>
            </form>

        </x-cards.main>
        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\Event', 'subject_id' => $event->id])
        </x-cards.main>
    </div>


    @livewire('event-attendee-search', ['event' => $event])


</x-app-layout>