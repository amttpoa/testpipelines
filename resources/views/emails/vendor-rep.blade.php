<x-email-layout>

    <x-slot name="name">
        {{ $name }}
    </x-slot>

    <div>
        {!! $email_body !!}
    </div>

    <div>
        You have been registered to be a vendor representative for <strong>{{ $submission->company_name }}</strong>
        at the <strong>{{ $submission->conference->name }}</strong>.
    </div>

    <div style="margin-top:50px; text-align:center;">
        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;font-size:20px;" href="{{ route('conference', $submission->conference ) }}">
                {{ $submission->conference->name }}
            </a>
        </div>
        <div style="font-weight: 700;">
            {{ $submission->conference->start_date->format('F j, Y') }} -
            {{ $submission->conference->end_date->format('F j, Y') }}
        </div>
        <div style="margin-top:20px;font-weight:400;font-size:12px;">
            Hosted at:
        </div>
        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;font-size:20px;" href="{{ route('venue', $submission->conference->venue ) }}">
                {{ $submission->conference->venue->name }}
            </a>
        </div>
        <div>
            {{ $submission->conference->venue->address }}<br>
            {{ $submission->conference->venue->city }},
            {{ $submission->conference->venue->state }}
            {{ $submission->conference->venue->zip }}
        </div>


    </div>

</x-email-layout>