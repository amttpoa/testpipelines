<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Vendors
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.vendors.create') }}">Create Vendor</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <h2 class="font-medium text-2xl mb-4">Vendors</h2>
        <div>
            @foreach($vendors as $vendor)
            <div class="">
                <a href="{{ route('admin.vendors.edit', $vendor) }}">
                    {{ $vendor->name }}
                </a>
            </div>

            @endforeach
        </div>
    </x-cards.main>

</x-app-layout>