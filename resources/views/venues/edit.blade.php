<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.venues.index') }}">Venues</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.venues.show', $venue) }}">{{ $venue->name }}</x-crumbs.a>
            Edit Venue
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.venues.update', $venue) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex gap-3">
                <x-fields.input-text label="Name" name="name" value="{!! $venue->name !!}" class="mb-3 flex-1" />
                <x-fields.select label="Contact Person" name="user_id" :selections="$users" :selected="$venue->user_id" placeholder=" " class="mb-3" />
            </div>

            <x-fields.input-text label="Address" name="address" value="{{ $venue->address }}" class="mb-3" />

            <div class="grid grid-cols-3 gap-3">
                <x-fields.input-text label="City" name="city" value="{{ $venue->city }}" class="mb-3" />
                <x-fields.input-text label="State" name="state" value="{{ $venue->state }}" class="mb-3" />
                <x-fields.input-text label="Zip" name="zip" value="{{ $venue->zip }}" class="mb-3" />
            </div>
            <div class="grid grid-cols-3 gap-3">
                <x-fields.input-text label="Phone" name="phone" value="{{ $venue->phone }}" class="mb-3" />
                <x-fields.input-text label="Website" name="website" value="{{ $venue->website }}" class="mb-3" />
                <x-fields.input-text label="Website Link" name="website_link" value="{{ $venue->website_link }}" class="mb-3" />
            </div>
            <x-fields.input-text label="Google Maps" name="google_maps" value="{!! $venue->google_maps !!}" class="mb-3" />

            <div class="mb-3">
                <x-label for="description">Description</x-label>
                <x-textarea id="description" name="description" class="addTiny mb-3">{{ $venue->description }}</x-textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-label for="hotels">Recommended Hotels</x-label>
                    @foreach($hotelsAll as $hotel)
                    <label class="flex gap-3 items-center ">
                        <input type="checkbox" name="hotel[]" value="{{ $hotel->id }}" {{ $venue->hotels->contains($hotel) ? 'checked' : '' }} />
                        {{ $hotel->name }}
                    </label>
                    @endforeach


                </div>
                <div>
                    <div class="mb-3">
                        <x-label for="image">Image</x-label>
                        <input id="image" name="image" type="file" />
                    </div>
                    @if($venue->image)
                    <img src="/storage/venues/{{ $venue->image }}" />
                    @endif
                </div>

            </div>


        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>