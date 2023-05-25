<x-site-layout>
    @section("pageTitle")
    {{ $conference->name }} Vendors
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Vendors</div>
    </x-banner>

    <div class="flex-1 bg-white text-center">

        @foreach($radios as $radio)
        <div class="py-8 {{ $loop->index % 2 > 0 ? 'bg-otsteel-200' : '' }}">
            <div class="max-w-5xl mx-auto m-4">
                <div class="font-bold font-blender text-3xl lg:text-5xl my-6">
                    {{ $radio->value }}s
                </div>
                <div class="flex flex-wrap justify-center">
                    @foreach($vendors->where('sponsorship', $radio->value) as $vendor)
                    @php
                    $bgColor = 'bg-white';
                    if($vendor->organization->name == 'HighCom Armor') {$bgColor = 'bg-black';}
                    if($vendor->organization->name == 'XGO') {$bgColor = 'bg-otsteel';}
                    @endphp
                    <div class="w-1/2 lg:w-1/3 p-3">
                        <a href="{{ route('conference.vendor', [$conference, $vendor]) }}">
                            <div class="">
                                <div class="h-40">
                                    <img class="w-40 h-40 p-2 object-contain inline border border-ot-steel rounded {{ $bgColor }}" src="{{ Storage::disk('s3')->url('organizations/' . ($vendor->organization->image ? $vendor->organization->image : 'no-organization.png')) }}" />
                                </div>
                                <div>
                                    <div class="mt-2 text-xl font-semibold">{{ $vendor->organization->name }}</div>

                                    <div class="mt-2 hidden">{{ $vendor->organization->short_description }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

    </div>

</x-site-layout>