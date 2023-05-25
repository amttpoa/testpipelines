<x-site-layout>
    @section("pageTitle")
    Kalahari Shipping and Receiving
    @endSection

    <x-banner bg="/img/form-banner.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Kalahari Shipping and Receiving</div>
    </x-banner>


    <div class="flex-1 bg-otsteel px-4">

        <div class="max-w-5xl h-full mx-auto bg-white shadow p-6 py-10">
            <div class="prose max-w-full sponsorships">
                {!! $information->content !!}
            </div>

            <div class="text-center mt-6">
                <x-button-link-site class="sm:text-xl" href="/resources/Kalahari-OH-shipping-delivery-FILLABLE-FORM.pdf" target="_blank">Download Kalahari Package &amp; Delivery Form</x-button-link-site>
            </div>
        </div>
    </div>

</x-site-layout>