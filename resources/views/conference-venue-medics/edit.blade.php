<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-venue-medics.index', $conference) }}">Medics</x-crumbs.a>
            Edit Medic
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.conference-venue-medics.destroy',  [$conference, $conferenceVenueMedic]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <form method="POST" id="main-form" x-data="slugHandler()" action="{{ route('admin.conference-venue-medics.update', [$conference, $conferenceVenueMedic]) }}">
            @csrf
            @method('PATCH')

            <x-label>Venue</x-label>
            <x-select name="venue_id" :selections="$conference->venues->pluck('name', 'id')" :selected="$conferenceVenueMedic->venue_id" placeholder=" " required />

            <x-label class="mt-4">User</x-label>
            <x-select name="user_id" :selections="$medics" placeholder=" " :selected="$conferenceVenueMedic->user_id" required />

            <x-label class="mt-4">Date</x-label>
            <x-input type="date" name="date" class="w-auto" value="{{ $conferenceVenueMedic->date ? $conferenceVenueMedic->date->format('Y-m-d') : '' }}" min="{{ $conference->start_date->toDateString() }}" max="{{ $conference->end_date->toDateString() }}" />

            <x-label class="mt-4">Note</x-label>
            <x-input name="note" value="{!! $conferenceVenueMedic->note !!}" />
        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>