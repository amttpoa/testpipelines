<x-dashboard.layout>
    @section("pageTitle")
    Change Password
    @endSection

    <x-breadcrumbs.holder>
        Change Password
    </x-breadcrumbs.holder>

    <form method="POST" id="main-form" enctype="multipart/form-data" action="{{ route('dashboard.changePasswordPatch') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3 w-60">
            <x-label for="password">Current Password</x-label>
            <x-input id="password" name="password" type="password" />
        </div>

        <div class="mb-3 w-60">
            <x-label for="new_password">New Password</x-label>
            <x-input id="new_password" name="new_password" type="password" />
        </div>

        <div class="mb-3 w-60">
            <x-label for="new_password_confirm">Confirm New Password</x-label>
            <x-input id="new_password_confirm" name="new_password_confirm" type="password" />
        </div>

        <div class="mt-6">
            <x-button form="main-form">Update Password</x-button>
        </div>

    </form>

</x-dashboard.layout>