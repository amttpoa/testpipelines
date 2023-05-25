<x-dashboard.layout>
    @section("pageTitle")
    Edit User
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.users') }}">Users</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.user', $user) }}">{{ $user->name }}</a>
        <x-breadcrumbs.arrow />
        Edit User
    </x-breadcrumbs.holder>

    <form method="POST" action="{{ route('dashboard.organization.users.update', $user) }}">
        @csrf
        @method("PATCH")

        <x-fields.input-text label="Name" name="name" value="{{ $user->name }}" class="max-w-sm mb-4" required />
        <div class="flex mb-4">
            <div>
                <x-label for="phone">Cell Phone</x-label>
                <x-input value="{{ $user->profile->phone }}" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" type="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" id="phone" name="phone" required />
            </div>
        </div>

        <x-button-site class="">
            Submit
        </x-button-site>
    </form>


</x-dashboard.layout>