<x-site-layout>
    @section("pageTitle")
    Venues
    @endSection

    <x-banner bg="/img/map-header.jpg">
        <div class="text-3xl lg:text-6xl">Venues</div>
    </x-banner>

    <div class="bg-white p-6 flex-1">

        @guest
        <div class="text-2xl text-center">
            You must
            <x-a href="{{ route('login') }}">login</x-a>
            to view our venues
        </div>
        @endguest

        @auth
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($venues as $venue)
                <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                    <div class="font-semibold text-xl">
                        <a href="{{ route('venue', $venue) }}">{{ $venue->name}}</a>
                    </div>
                    <div>
                        {{ $venue->address }}<br>
                        {{ $venue->city }}, {{ $venue->state }} {{ $venue->zip }}
                    </div>
                    <div>
                        {{ $venue->phone }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endauth

    </div>

</x-site-layout>