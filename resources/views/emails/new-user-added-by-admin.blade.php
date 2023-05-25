<x-email-layout>

    <x-slot name="name">
        {{ $user->name }}
    </x-slot>

    <div>
        <p>
            An account has been created for you at <a style="color:#a42510;font-weight:700;text-decoration:none;" href="{{ config('app.url') }}">TTPOA.org</a>.
        </p>
        <p>
            Please use the <a style="color:#a42510;font-weight:700;text-decoration:none;" href="{{ config('app.url') }}/forgot-password">Forgot Password</a> link to reset your password and login to your account.
        </p>
    </div>

    <div>
    </div>


</x-email-layout>