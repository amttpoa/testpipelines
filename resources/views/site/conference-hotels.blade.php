<x-site-layout>
    @section("pageTitle")
    Conference Hotels
    @endSection

    <x-banner bg="/img/map-header.jpg">
        <div class="text-3xl lg:text-6xl">Conference Hotels</div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="max-w-4xl bg-white mx-auto p-6 py-12">

            <div class="max-w-2xl mx-auto p-6 text-center text-xl">
                The hotels listed on this page have been vetted and recommended by the host agencies.
                All of the properties listed offer a government rate or an OTOA preferred rate.
                Room rates are at the discretion of the hotel property and not controlled by the OTOA.
            </div>

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($hotels as $hotel)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 py-6">
                    <div class="font-semibold text-xl">
                        <a href="{{ route('hotel', $hotel) }}">{{ $hotel->name}}</a>
                    </div>
                    <div>
                        <a href="{{ route('hotel', $hotel) }}">
                            {{ $hotel->address }}<br>
                            {{ $hotel->city }}, {{ $hotel->state }} {{ $hotel->zip }}
                        </a>
                    </div>
                    <div>
                        {{ $hotel->phone }}
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-site-layout>