<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.hotels.index') }}">Hotels</x-crumbs.a>
            Edit Hotel
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.hotels.update', $hotel) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Name" name="name" value="{!! $hotel->name !!}" class="mb-3" />
            <x-fields.input-text label="Address" name="address" value="{{ $hotel->address }}" class="mb-3" />

            <div class="grid grid-cols-3 gap-3">
                <x-fields.input-text label="City" name="city" value="{{ $hotel->city }}" class="mb-3" />
                <x-fields.input-text label="State" name="state" value="{{ $hotel->state }}" class="mb-3" />
                <x-fields.input-text label="Zip" name="zip" value="{{ $hotel->zip }}" class="mb-3" />
            </div>

            <div class="grid grid-cols-3 gap-3">
                <x-fields.input-text label="Phone" name="phone" value="{{ $hotel->phone }}" class="mb-3" />
                <x-fields.input-text label="Website" name="website" value="{{ $hotel->website }}" class="mb-3" />
                <x-fields.input-text label="Website Link" name="website_link" value="{{ $hotel->website_link }}" class="mb-3" />
            </div>

            <x-fields.input-text label="Google Maps" name="google_maps" value="{!! $hotel->google_maps !!}" class="mb-3" />

            <div>
                <x-label for="description">Description</x-label>
                <x-textarea id="description" name="description" class="addTiny mb-3">{{ $hotel->description }}</x-textarea>
            </div>

            <div class="font-medium text-xl mt-4">
                Venues
            </div>
            @foreach($hotel->venues as $venue)
            <div>
                <a href="{{ route('admin.venues.edit', $venue) }}">{{ $venue->name }}</a>
            </div>
            @endforeach
        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>