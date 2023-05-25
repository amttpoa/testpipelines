<x-site-layout>
    @section("pageTitle")
    Exhibitor Information
    @endSection

    <x-banner bg="/img/form-banner.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Exhibitor Information</div>
    </x-banner>


    <div class="flex-1 bg-otsteel">

        <div class="max-w-5xl h-full mx-auto bg-white shadow p-6 py-10">
            <div class="prose max-w-full sponsorships">
                {!! $information->content !!}
            </div>
        </div>
    </div>

</x-site-layout>