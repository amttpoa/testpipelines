<x-site-layout>
    @section("pageTitle")
    {{ $course->name }}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">{{ $course->name }}</div>
    </x-banner>


    <div class="flex-1 bg-otsteel">
        <div class="max-w-6xl bg-white h-full mx-auto p-6">


            <div class="lg:flex lg:gap-4">
                <div class="lg:flex-1 mb-6">
                    <div class="font-medium text-2xl">{{ $course->name }}</div>
                    <div class="font-medium text-lg">
                        {{ $course->start_date->format('F j, Y') }}
                        <span class="ml-3 text-otgray">
                            {{ $course->start_date->format('H:i') }} -
                            {{ $course->end_date->format('H:i') }}
                        </span>
                    </div>
                    <div class="mb-4">
                        @foreach($course->courseTags as $tag)
                        <div class="text-sm inline-block mr-1 rounded-full bg-otgray px-2 text-white">{{ $tag->name }}</div>
                        @endforeach
                    </div>
                    @if($course->venue)
                    <x-a class="text-xl" href="{{ route('venue', $course->venue) }}">
                        {{ $course->venue->name }}
                    </x-a>
                    @endif
                    <div class="font-medium">
                        {{ $course->location }}
                    </div>
                    @if($course->venue)
                    @guest
                    <x-a href="{{ route('login') }}">Login</x-a> to see address
                    @endguest
                    @auth
                    <div>{{ $course->venue->address }}</div>
                    @endauth
                    <div>
                        {{ $course->venue->city }},
                        {{ $course->venue->state }}
                        {{ $course->venue->zip }}
                    </div>
                    @endif

                </div>
                @if($course->user)
                <div class="mb-6">
                    <div class="text-center">
                        <a class="text-center inline-block" href="{{ route('staffProfile', $course->user) }}">
                            <x-profile-image class="w-40 h-40 inline" :profile="$course->user->profile" />
                            <div class="font-medium text-xl">{{ $course->user->name }}</div>
                            <div class="text-otgray">
                                {{ $course->user->profile->title }}
                            </div>
                        </a>
                    </div>
                </div>
                @endif

                @if($course->users->isNotEmpty())
                <div class="lg:max-w-md mb-6 flex flex-wrap justify-center gap-3 lg:mt-10">
                    @foreach($course->users as $user)
                    <div class="text-center w-28">
                        <a class="text-center inline-block" href="{{ route('staffProfile', $user) }}">
                            <x-profile-image class="w-20 h-20 inline" :profile="$user->profile" />
                            <div class="font-medium mt-2 leading-tight">{{ $user->name }}</div>
                            <div class="text-otgray text-sm leading-tight mt-1">
                                {{ $user->profile->title }}
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <h2 class="text-2xl">Course Description</h2>
            <div class="prose max-w-full mb-6">
                {!! $course->description !!}
            </div>

            <h2 class="text-2xl mt-6">Student Requirements</h2>
            <div class="prose max-w-full mb-6">
                {!! $course->requirements !!}
            </div>

        </div>
    </div>

</x-site-layout>