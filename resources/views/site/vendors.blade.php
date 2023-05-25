<x-site-layout>
    @section("pageTitle")
    Preferred Vendors
    @endSection

    <x-banner bg="/img/map-header.jpg">
        <div class="text-3xl lg:text-6xl">Preferred Vendors</div>
    </x-banner>

    <div class="max-w-2xl mx-auto px-6 py-10 text-center text-xl">
        <div class="mb-5">
            This comprehensive list of companies has been vetted by the OTOA and offers the very best products and services.
        </div>
        <div class="mb-5">
            Interested in becoming a partner of the OTOA and joining the list of OTOA preferred vendor companies?
        </div>
        <div>
            Send an email to:
            <x-a href="mailto:office@otoa.org">office@otoa.org</x-a>
        </div>

    </div>

    <div class="flex-1 bg-white text-center">

        <div class="py-8">
            <div class="max-w-5xl mx-auto m-4">

                <div class="flex flex-wrap justify-center">
                    @foreach($organizations as $organization)
                    <div class="w-1/2 lg:w-1/3 p-3">

                        <a href="{{ route('vendor', $organization->vendorPage) }}">
                            <div class="">
                                <div class="h-40">
                                    <img class="w-40 h-40 p-2 object-contain inline border border-ot-steel rounded bg-white" src="{{ Storage::disk('s3')->url('organizations/' . ($organization->image ? $organization->image : 'no-organization.png')) }}" />
                                </div>
                                <div>
                                    <div class="mt-2 text-xl font-semibold">{{ $organization->name }}</div>

                                    <div class="mt-2 hidden">{{ $organization->short_description }}</div>
                                </div>
                            </div>
                        </a>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>




    <section class="bg-white flex-1 hidden">

        <div class="max-w-2xl mx-auto m-8">

            <div class="text-xl mb-8 text-center">
                Maybe something about the vendors can go here. Something about Opportunities Available: See Vendor Registration.
            </div>
            @foreach($vendors as $vendor)
            <div>
                <a class="flex gap-6 items-center p-4 {{ $loop->index % 2 > 0 ? 'bg-otsteel-200' : '' }}" href="{{ route('vendor', $vendor->slug) }}">
                    <img src="/storage/vendors/{{ $vendor->image }}" class="w-32 lg:w-48">
                    <div class="text-xl font-semibold">{{ $vendor->name }}</div>
                </a>
            </div>
            @endforeach

        </div>

    </section>

</x-site-layout>