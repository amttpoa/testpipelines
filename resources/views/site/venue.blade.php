<x-site-layout>
    @section("pageTitle")
    {!! $venue->name !!}
    @endSection

    <x-banner bg="/img/map-header.jpg">
        <div class="text-3xl lg:text-6xl"><a href="{{ route('venues') }}">Venues</a></div>
        <div class="text-xl lg:text-2xl">{{ $venue->name }}</div>
    </x-banner>

    @guest
    <div class="flex-1 bg-white p-6">
        <div class="text-2xl text-center">
            You must
            <x-a href="{{ route('login') }}">login</x-a>
            to view our venues
        </div>
    </div>
    @endguest

    @auth
    <div class="flex-1 bg-white p-6 py-12">

        <div class="max-w-5xl mx-auto">
            <div class="grid {{ $venue->image ? 'lg:grid-cols-2' : '' }} gap-6 mb-6">

                <div>
                    <div class="text-xl lg:text-3xl font-semibold">
                        {{ $venue->name }}
                    </div>
                    <div class="text-lg">
                        <div>{{ $venue->address }}</div>
                        <div>
                            {{ $venue->city ? $venue->city . ', ' : '' }}
                            {{ $venue->state }}
                            {{ $venue->zip }}
                        </div>
                        <div>{{ $venue->phone }}</div>
                        @if($venue->website_link)
                        <div>
                            <a href="{{ $venue->website_link }}" class="text-otgold font-semibold" target="_blank">{{ $venue->website ? $venue->website : $venue->website_link }}</a>
                        </div>
                        @endif
                    </div>
                    <div class="mt-4 prose max-w-full">
                        {!! $venue->description !!}
                    </div>
                </div>
                @if($venue->image)
                <div>
                    <img src="/storage/venues/{{ $venue->image }}" />
                </div>
                @endif
            </div>

            <div>
                {!! $venue->google_maps !!}
            </div>


        </div>

    </div>

    <div class="bg-otsteel">
        <div class="max-w-5xl mx-auto py-12">
            <div class="text-center text-5xl p-6 font-blender font-bold">Recommended Hotels</div>

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($venue->hotels as $hotel)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 py-6">
                    <div class="font-semibold text-xl">
                        <a href="{{ route('hotel', $hotel) }}">{{ $hotel->name}}</a>
                    </div>
                    <div>
                        {{ $hotel->address }}<br>
                        {{ $hotel->city }}, {{ $hotel->state }} {{ $hotel->zip }}
                    </div>
                    <div>
                        {{ $hotel->phone }}
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    <div class="bg-white py-8">
        <div class="max-w-3xl mx-auto m-4">

            <div class="text-center text-5xl p-6 font-blender font-bold">Upcoming Events At This Location</div>

            @foreach($courses as $index => $conference)
            <x-info-h class="text-center mt-8">{{ $index }}</x-info-h>
            <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
                @foreach($conference as $course)
                <a href="{{ route('course', [$course->conference, $course]) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $course->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $course->start_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $course->start_date->format('H:i') }} -
                                    {{ $course->end_date->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="font-medium">
                            <div>{{ $course->user ? $course->user->name : ''}}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endforeach





            <x-info-h class="text-center mt-8">Advanced Training</x-info-h>
            @if($trainingCourses->isEmpty())
            <div class="font-light text-lg text-red-500 text-center">No upcoming advanced training at this venue</div>
            @else
            <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
                @foreach($trainingCourses as $course)
                <a href="{{ route('trainingCourse', [$course->training, $course]) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $course->training->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $course->start_date->format('m/d/Y') }} -
                                    {{ $course->end_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $course->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="font-medium">
                            <div>{{ $course->user ? $course->user->name : ''}}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif


        </div>
    </div>

    @endauth

</x-site-layout>