<x-site-layout>
    @section("pageTitle")
    {!! $hotel->name !!}
    @endSection

    <x-banner bg="/img/map-header.jpg">
        <div class="text-3xl lg:text-6xl"><a href="{{ route('hotels') }}">Hotels</a></div>
        <div class="text-xl lg:text-2xl">{{ $hotel->name }}</div>
    </x-banner>

    <div class="flex-1 bg-white p-6 py-12">

        <div class="max-w-5xl mx-auto">

            <div class="grid {{ $hotel->image ? 'lg:grid-cols-2' : '' }} gap-6 mb-6">

                <div>
                    <div class="text-xl lg:text-3xl font-semibold">
                        {{ $hotel->name }}
                    </div>
                    <div class="text-lg">
                        <div>{{ $hotel->address }}</div>
                        <div>
                            {{ $hotel->city ? $hotel->city . ', ' : '' }}
                            {{ $hotel->state }}
                            {{ $hotel->zip }}
                        </div>
                        <div>{{ $hotel->phone }}</div>
                        @if($hotel->website_link)
                        <div>
                            <a href="{{ $hotel->website_link }}" class="text-otgold font-semibold" target="_blank">{{ $hotel->website ? $hotel->website : $hotel->website_link }}</a>
                        </div>
                        @endif
                    </div>
                    <div class="prose text-lg max-w-full mt-4">
                        {!! $hotel->description !!}
                    </div>
                </div>
                @if($hotel->image)
                <div>
                    <img src="/storage/hotels/{{ $hotel->image }}" />
                </div>
                @endif
            </div>

            <div>
                {!! $hotel->google_maps !!}
            </div>


        </div>

    </div>


    <div class="bg-otsteel">
        <div class="max-w-5xl mx-auto py-12">
            <div class="text-center text-5xl p-6 font-blender font-bold">Venues Near Here</div>

            @guest
            <div class="p-6">
                <div class="text-2xl text-center">
                    You must
                    <x-a href="{{ route('login') }}">login</x-a>
                    to view our venues
                </div>
            </div>
            @endguest

            @auth
            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($hotel->venues as $venue)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 py-6">
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
            @endauth

        </div>
    </div>


</x-site-layout>