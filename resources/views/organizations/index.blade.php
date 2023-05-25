<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Organizations
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.organizations.export') }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank" download>Export</a>
        </x-page-menu>
        <div>
            <x-button-link href="{{ route('admin.organizations.create') }}">Create Organization</x-button-link>
        </div>
    </x-crumbs.bar>

    @livewire('organization-search')

</x-app-layout>