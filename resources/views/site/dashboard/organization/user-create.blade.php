<x-dashboard.layout>
    @section("pageTitle")
    Add User
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.users') }}">Users</a>
        <x-breadcrumbs.arrow />
        Add User
    </x-breadcrumbs.holder>


    <div class="mb-4 max-w-md">
        Add a new user to your organization, <strong>{{ $organization->name }}</strong>.
        We will send them an email with instructions to create their password.
    </div>

    @if (\Session::has('found'))
    <div class="mb-4 max-w-md p-4 bg-red-50 border border-red-900 text-red-900">
        The email address <span class="font-medium">{!! \Session::get('found') !!}</span> is already a user.
        If you would like this user to be part of your organization, please contact
        <x-a href="mailto:office@otoa.org">office@otoa.org</x-a>.
    </div>
    @endif

    <form method="POST" action="{{ route('dashboard.organization.user-store') }}">
        @csrf

        <x-fields.input-text label="Name" name="name" class="max-w-sm mb-4" required />
        <x-fields.input-text label="Email" name="email" class="max-w-sm mb-4" required />

        <div class="flex mb-4">
            <div>
                <x-label for="phone">Cell Phone</x-label>
                <x-input x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" type="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" id="phone" name="phone" required />
            </div>
        </div>

        <x-button-site class="">
            Submit
        </x-button-site>
    </form>


</x-dashboard.layout>