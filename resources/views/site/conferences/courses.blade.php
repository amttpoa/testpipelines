<x-site-layout>
    @section("pageTitle")
    {{ $conference->name }}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Courses</div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="max-w-6xl bg-white h-full mx-auto p-6">

            @foreach($courses as $key => $coursesGroup)
            <div class="font-medium text-2xl mb-2">{{ $key }}</div>
            <div class="mb-6 border-t border-otgray">
                @foreach($coursesGroup as $course)
                <a href="{{ route('course', [$conference, $course]) }}" class="flex gap-3 py-1 border-b border-otgray">
                    <div class="w-28 font-medium">
                        {{ $course->start_date->format('H:i') }} -
                        {{ $course->end_date->format('H:i') }}
                    </div>
                    <div class="flex-1">
                        {{ $course->name }}
                    </div>
                </a>

                @endforeach
            </div>
            @endforeach
        </div>
    </div>

</x-site-layout>