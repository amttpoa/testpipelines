<x-email-layout>


    <x-slot name="name">
        {{ $trainingCourseAttendee->user->name }}
    </x-slot>

    <div style="color:#000000;">
        <p style="font-size:24px;font-weight:bold;">Test</p>
        <p>
            <span style="font-size:20px;font-weight:bold;">{{ $trainingCourseAttendee->user->name }}</span><br>
        </p>
        <p>{{ $trainingCourseAttendee->user->name }}</p>
        <p style="text-align: center;">
            <a href="/" style="display:inline-block;text-decoration:none;border-radius:7px;background-color:#135d91;padding:8px 16px;color:#fff;">
                View Contract
            </a>
        </p>
    </div>



</x-email-layout>