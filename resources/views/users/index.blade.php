<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Users
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.users.send-emails') }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Send Emails</a>
        </x-page-menu>
        <div>
            <x-button-link href="{{ route('admin.users.create') }}">Create User</x-button-link>
        </div>
    </x-crumbs.bar>

    @livewire('user-search')

</x-app-layout>