<x-site-layout>
    @section("pageTitle")
    Hotels
    @endSection

    <x-banner bg="/img/map-header.jpg">
        <div class="text-3xl lg:text-6xl">Hotels</div>
    </x-banner>

    <section class="bg-white border-b py-8 flex-1">

        <div class="max-w-2xl mx-auto p-6 text-center text-xl">
            The hotels listed on this page have been vetted and recommended by the host agencies.
            All of the properties listed offer a government rate or an OTOA preferred rate.
            Room rates are at the discretion of the hotel property and not controlled by the OTOA.
        </div>

        <div class="max-w-5xl mx-auto m-8">

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

    </section>

</x-site-layout>