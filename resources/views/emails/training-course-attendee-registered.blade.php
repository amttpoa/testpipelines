<x-email-layout>

    <x-slot name="name">
        {{ $name }}
    </x-slot>

    <div>
        {!! $email_body !!}
    </div>

    <div>
        You have been registered for
        <strong>{{ $trainingCourseAteendee->trainingCourse->training->name }}</strong>
        running from
        <strong>{{ $trainingCourseAteendee->trainingCourse->start_date->format('F j, Y') }}</strong>
        to
        <strong>{{ $trainingCourseAteendee->trainingCourse->end_date->format('F j, Y') }}</strong>.
    </div>

    <div style="margin-top:50px; text-align:center;">
        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;font-size:20px;" href="{{ route('trainingCourse', [$trainingCourseAteendee->trainingCourse->training, $trainingCourseAteendee->trainingCourse] ) }}">
                {{ $trainingCourseAteendee->trainingCourse->training->name }}
            </a>
        </div>
        <div style="font-weight: 700;">
            {{ $trainingCourseAteendee->trainingCourse->start_date->format('F j, Y') }} -
            {{ $trainingCourseAteendee->trainingCourse->end_date->format('F j, Y') }}
        </div>
        <div style="margin-top:20px;font-weight:400;font-size:12px;">
            Hosted at:
        </div>
        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;font-size:20px;" href="{{ route('venue', $trainingCourseAteendee->trainingCourse->venue ) }}">
                {{ $trainingCourseAteendee->trainingCourse->venue->name }}
            </a>
        </div>
        <div>
            {{ $trainingCourseAteendee->trainingCourse->venue->address }}<br>
            {{ $trainingCourseAteendee->trainingCourse->venue->city }},
            {{ $trainingCourseAteendee->trainingCourse->venue->state }}
            {{ $trainingCourseAteendee->trainingCourse->venue->zip }}
        </div>


    </div>

</x-email-layout>