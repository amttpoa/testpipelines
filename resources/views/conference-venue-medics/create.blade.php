<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-venue-medics.index', $conference) }}">Medics</x-crumbs.a>
            Add Medic
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <form method="POST" id="main-form" x-data="slugHandler()" action="{{ route('admin.conference-venue-medics.store', $conference) }}">
            @csrf

            <x-label>Venue</x-label>
            <x-select name="venue_id" :selections="$conference->venues->pluck('name', 'id')" placeholder=" " required />

            <x-label class="mt-4">User</x-label>
            <x-select name="user_id" :selections="$medics" placeholder=" " required />

            <x-label class="mt-4">Date</x-label>
            <x-input type="date" name="date" class="w-auto" min="{{ $conference->start_date->toDateString() }}" max="{{ $conference->end_date->toDateString() }}" />

            <x-label class="mt-4">Note</x-label>
            <x-input name="note" />
        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>