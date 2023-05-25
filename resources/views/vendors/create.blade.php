<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.vendors.index') }}">Vendors</x-crumbs.a>
            Create Vendor
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.vendors.store') }}">
            @csrf

            <x-fields.input-text label="Name" name="name" class="mb-3" />
            <x-fields.input-text label="Address" name="address" class="mb-3" />
            <x-fields.input-text label="City" name="city" class="mb-3" />
            <x-fields.input-text label="State" name="state" class="mb-3" />
            <x-fields.input-text label="Zip" name="zip" class="mb-3" />
            <x-fields.input-text label="email" name="email" class="mb-3" />
            <x-fields.input-text label="phone" name="phone" class="mb-3" />
            <x-fields.input-text label="fax" name="fax" class="mb-3" />
            <x-fields.input-text label="website" name="website" class="mb-3" />
            <x-fields.input-text label="website_link" name="website_link" class="mb-3" />

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