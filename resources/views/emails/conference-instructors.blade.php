<x-email-layout>

    <x-slot name="name">
        {{ $user->name }}
    </x-slot>

    <div>
        {!! $body !!}
    </div>



    <div style="margin-top:40px; font-size:14px;">
        <div style="font-weight:700; font-size:18px; padding-bottom:10px; text-align:center; border-bottom:1px solid #858585;">Your conference schedule of courses you are teaching</div>
        @foreach($user->conferenceCoursesTeaching($conference) as $course)
        <a style="color:#000000;text-decoration:none;" href="{{ route('course', [$course->conference, $course]) }}">
            <div style="padding:10px;{{ $loop->index % 2 > 0 ? 'background-color:#f0f0f0;' : '' }}">
                <div style="font-size:18px;font-weight:700;">{{ $course->name }}</div>
                <div style="font-size:16px;font-weight:700;">
                    {{ $course->start_date->format('F j') }}
                    <span style="color:#858585;font-weight:400;margin-left:10px;">
                        {{ $course->start_date->format('H:i') }} - {{ $course->end_date->format('H:i') }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

</x-email-layout>