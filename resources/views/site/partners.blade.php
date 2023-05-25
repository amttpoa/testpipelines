<x-site-layout>
    @section("pageTitle")
    Training Partners
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-3xl lg:text-6xl">Training Partners</div>
    </x-banner>

    <div class="max-w-2xl mx-auto px-6 py-10 text-center text-xl">
        <div class="mb-5">
            The training companies listed on this page have been vetted by the OTOA Advanced Training Division and meet our stringent criteria as an OTOA approved trainng partner.
        </div>
        <div class="mb-5 font-medium text-2xl">
            Train with confidence.
        </div>
        <div class="hidden">
            Something about an email to:
            <x-a href="mailto:office@otoa.org">office@otoa.org</x-a>
        </div>

    </div>

    <div class="flex-1 bg-white text-center">

        <div class="py-8">
            <div class="max-w-5xl mx-auto m-4">

                <div class="flex flex-wrap justify-center">
                    @foreach($organizations as $organization)
                    <div class="w-1/2 lg:w-1/3 p-3">

                        <a href="{{ route('partner', $organization->partner) }}">
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

</x-site-layout>