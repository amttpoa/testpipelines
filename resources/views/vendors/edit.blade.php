<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.vendors.index') }}">Vendors</x-crumbs.a>
            Edit Vendor
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.vendors.update', $vendor) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Name" name="name" value="{{ $vendor->name }}" class="mb-3" />
            <x-fields.input-text label="Address" name="address" value="{{ $vendor->address }}" class="mb-3" />
            <x-fields.input-text label="City" name="city" value="{{ $vendor->city }}" class="mb-3" />
            <x-fields.input-text label="State" name="state" value="{{ $vendor->state }}" class="mb-3" />
            <x-fields.input-text label="Zip" name="zip" value="{{ $vendor->zip }}" class="mb-3" />
            <x-fields.input-text label="email" name="email" value="{{ $vendor->email }}" class="mb-3" />
            <x-fields.input-text label="phone" name="phone" value="{{ $vendor->phone }}" class="mb-3" />
            <x-fields.input-text label="fax" name="fax" value="{{ $vendor->fax }}" class="mb-3" />
            <x-fields.input-text label="website" name="website" value="{{ $vendor->website }}" class="mb-3" />
            <x-fields.input-text label="website_link" name="website_link" value="{{ $vendor->website_link }}" class="mb-3" />

            <div>
                <x-label for="description">Description</x-label>
                <x-textarea id="description" name="description" class="addTiny mb-3">{{ $vendor->description }}</x-textarea>
            </div>

        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>