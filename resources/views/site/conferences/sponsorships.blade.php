<x-site-layout>
    @section("pageTitle")
    Vendor Registration
    @endSection

    <x-banner bg="/img/form-banner.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Vendor Registration</div>
    </x-banner>


    <div class="flex-1 bg-otsteel px-4">

        <div class="max-w-5xl h-full mx-auto bg-white shadow p-6 py-10">
            <div class="prose max-w-full sponsorships">
                {!! $sponsorships->content !!}
            </div>
            <div class="text-center mt-10">
                <x-button-link-site href="{{ route('exhibitionRegistration', $conference) }}" class="text-xl">Vendor Registration</x-button-link-site>
            </div>
        </div>
    </div>

</x-site-layout>