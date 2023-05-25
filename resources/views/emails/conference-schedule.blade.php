<x-email-layout>


    <x-slot name="name">
        {{ $attendee->user->name }}
    </x-slot>

    <div>
        {!! $email_body !!}
    </div>

    @if(!$attendee->paid)
    <div style="margin-top:40px;">
        <div style="font-weight:700; font-size:18px; padding-bottom:10px; text-align:center; border-bottom:1px solid #858585;">Conference invoicing information</div>
        <div style="padding:10px;">
            Your invoice will be sent to <strong>{{ $attendee->name }}</strong> at <strong>{{ $attendee->email }}</strong>.
            If you would like it sent to someone else please contact us at
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;" href="mailto:office@otoa.org">office@otoa.org</a>.
        </div>
    </div>
    @endif

    <div style="margin-top:40px; font-size:14px;">
        <div style="font-weight:700; font-size:18px; padding-bottom:10px; text-align:center; border-bottom:1px solid #858585;">Your conference course schedule</div>
        @foreach($attendee->courseAttendees as $att)
        <a style="color:#000000;text-decoration:none;" href="{{ route('course', [$attendee->conference, $att->course]) }}">
            <div style="padding:10px;{{ $loop->index % 2 > 0 ? 'background-color:#f0f0f0;' : '' }}">
                <div style="font-size:18px;font-weight:700;">{{ $att->course->name }}</div>
                <div style="font-size:16px;font-weight:700;">
                    {{ $att->course->start_date->format('F j') }}
                    <span style="color:#858585;font-weight:400;margin-left:10px;">
                        {{ $att->course->start_date->format('H:i') }} - {{ $att->course->end_date->format('H:i') }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>



</x-email-layout>