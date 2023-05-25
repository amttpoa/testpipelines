<x-email-layout>

    <x-slot name="name">
        {{ $user->name }}
    </x-slot>

    @if($user->can('vendor'))
    <div>
        @if($user->organization)
        <p>
            Thank you for creating the vendor company profile for
            <span style="font-weight:bold;">{{ $user->organization->name }}</span>.
        </p>
        <p>
            You are a Vendor Company Administrator. You have the authority to:
        </p>
        <ul>
            <li>register for conference vendor shows</li>
            <li>control exhibitor name badges</li>
            <li>edit the company profile</li>
            <li>add or change the company logo</li>
        </ul>
        <p style="margin-top:40px;text-align:center;">
            <a href="{{ route('dashboard') }}" style="display:inline-block;background:#D49C6A;color:#FFFFFF;font-family:Roboto;font-size:14px;font-weight:bold;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px;mso-padding-alt:0px;border-radius:10px;" target="_blank">Vendor Show Registration</a>
        </p>
        @else
        <p>
            Thank you for starting the process to create a vendor company profile for
            <span style="font-weight:bold;">{{ $user->profile->organization_name }}</span>.
            {{ $user->profile->organization_name }}
            is not currently in our vendor company database.
            A member of the OTOA Conference Vendor Show team will be in contact with you within 24 hours of this notice.
            We welcome all inquiries to
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;" href="mailto:office@otoa.org">office@otoa.org</a>.
        </p>
        @endif
    </div>

    @else
    <div>
        {!! $body !!}
    </div>

    @endif

</x-email-layout>