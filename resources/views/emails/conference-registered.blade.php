<x-email-layout>


    <x-slot name="name">
        {{ $conferenceAttendee->user->name }}
    </x-slot>

    <div style="text-align:center;font-size:12px;margin-bottom:20px;">
        <div style="line-height:12px;">You have been registered for the</div>
        <div>
            <a style="color:#000;font-size:22px;" href="{{ route('conference', $conferenceAttendee->conference) }}" target="_blank">{{ $conferenceAttendee->conference->name }}</a>
        </div>
    </div>
    <div style="text-align:center;font-size:12px;margin-bottom:30px;">
        <div style="line-height:12px;">Hosted at</div>
        <div>
            <a style="color:#000;font-size:22px;" href="{{ route('venue', $conferenceAttendee->conference->venue) }}" target="_blank">{{ $conferenceAttendee->conference->venue->name }}</a>
        </div>
        <div style="line-height:12px;">
            {{ $conferenceAttendee->conference->venue->city }}, {{ $conferenceAttendee->conference->venue->state }}
        </div>
    </div>

    <table style="width:100%;margin-bottom:30px;">
        <tr>
            <td></td>
            <td style="width:250px;">
                <div style="padding:15px 0px;border-bottom:1px solid #858585;text-align:center;font-size:12px;">
                    <div style="line-height:12px;">Reserve your room at</div>
                    <div style="font-weight:bold;font-size:20px;">Kalahari</div>
                    <div style="line-height:12px;">on</div>
                    <div><a style="color:#d49c6a;font-size:18px;" href="https://book.passkey.com/event/50439177/owner/49785631/home" target="_blank">book.passkey.com</a></div>
                </div>
                <div style="padding:15px 0px;border-bottom:1px solid #858585;text-align:center;font-size:12px;">
                    <div style="line-height:12px;">Find more lodging options on</div>
                    <div><a style="color:#d49c6a;font-size:18px;" href="https://otoa.org/conference-hotels" target="_blank">otoa.org</a></div>
                </div>
                <div style="padding:15px 0px;border-bottom:1px solid #858585;text-align:center;font-size:12px;">
                    <div style="line-height:12px;">Find more info on your</div>
                    <div><a style="color:#d49c6a;font-size:18px;" href="https://otoa.org/dashboard" target="_blank">Dashboard</a></div>
                </div>
                <div style="padding:15px 0px;text-align:center;font-size:12px;">
                    <div style="line-height:12px;">Need to make changes? Email us at</div>
                    <div><a style="color:#d49c6a;font-size:18px;" href="mailto:training@otoa.org" target="_blank">training@otoa.org</a></div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>

    <div>
        <p style="text-align:center;font-size:20px;font-weight:300;">
            Courses you are registered for
        </p>
        <div style="border-top:1px solid #858585;">
            @foreach($conferenceAttendee->courseAttendees as $courseAttendee)
            <div style="border-bottom:1px solid #858585;padding:10px 0px;">
                <div>
                    <a style="color:#000;" href="{{ route('course', [$courseAttendee->course->conference, $courseAttendee->course]) }}">
                        <div style="font-size:18px;font-weight:bold;">{{ $courseAttendee->course->name }}</div>
                        <div>
                            <span style="font-size:16px;font-weight:400;">{{ $courseAttendee->course->start_date->format('m/d/Y') }}</span>
                            <span style="font-size:12px;font-weight:400;color:#858585;margin-left:15px;">
                                {{ $courseAttendee->course->start_date->format('H:i') }} -
                                {{ $courseAttendee->course->end_date->format('H:i') }}
                            </span>
                        </div>
                    </a>
                </div>
                <table style="margin-top:5px;font-size:12px;">
                    <tr>
                        <td style="vertical-align:top;white-space:nowrap;text-align:right;padding-right:5px;">Location:</td>
                        <td style="vertical-align:top;font-weight:bold;">
                            @if($courseAttendee->course->venue)
                            <a style="color:#000;" href="{{ route('venue', $courseAttendee->course->venue) }}">
                                {{ $courseAttendee->course->venue->name }}
                                {{ $courseAttendee->course->location ? ' - ' . $courseAttendee->course->location : '' }}
                            </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;white-space:nowrap;text-align:right;padding-right:5px;">Instructor:</td>
                        <td style="vertical-align:top;font-weight:bold;">
                            @if($courseAttendee->course->user)
                            <a style="color:#000;" href="{{ route('staffProfile', $courseAttendee->course->user) }}">
                                {{ $courseAttendee->course->user->name }}
                            </a>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach
        </div>

    </div>



</x-email-layout>