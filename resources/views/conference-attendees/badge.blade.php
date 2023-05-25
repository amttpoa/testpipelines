<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-attendees.index', $conference) }}">Attendees</x-crumbs.a>
            Badge
        </x-crumbs.holder>
    </x-crumbs.bar>



    <x-cards.main>

        <form method="POST" id="main-form" action="{{ route('admin.conference-attendees.badge', $conference) }}" target="_blank">
            @csrf
            <x-fields.input-text label="First Name" name="card_first_name" value="" class="mb-3" />
            <x-fields.input-text label="Last Name" name="card_last_name" value="" class="mb-3" />
            <x-fields.input-text label="Organization Name" name="card_organization" value="" class="mb-3" />
            <x-fields.input-text label="Package/Sponsorship" name="card_package" value="" class="mb-3" />
            <x-fields.input-text label="Type" name="card_type" value="" class="mb-3" />
            <x-label>View</x-label>
            <x-select name="item" :selections="['PDF Badge' => 'PDF Badge', 'View Badge' => 'View Badge']" />

        </form>
    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Produce</x-button>
    </div>

</x-app-layout>