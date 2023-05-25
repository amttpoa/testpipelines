<x-site-layout>
    @section("pageTitle")
    Conferences
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">Conferences</div>
    </x-banner>

    <section class="bg-otsteel">
        <div class="max-w-5xl mx-auto">

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($conferences as $conference)
                <div class="w-full md:w-1/2 p-4">
                    <a href="{{ route('conference', $conference->slug) }}" class="h-full text-center block p-6 text-center bg-white hover:bg-otgray-100">
                        <div class="font-medium text-3xl">{{ $conference->name }}</div>
                        <div class="font-medium">${{ $conference->price }} | {{ $conference->start_date->format('F j') }} - {{ $conference->end_date->format('j | Y') }}</div>
                        <div class="font-light text-xl m-2">at</div>
                        <div class="text-xl font-medium">{{ $conference->venue->name }}</div>
                        <div class="text-lg font-condensed">{{ $conference->venue->city }}, {{ $conference->venue->state }}</div>
                        <div class="mt-6 text-xl inline-flex items-center px-5 py-2 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-500 active:bg-otgold-600 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150">
                            Register Now
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </section>


</x-site-layout>