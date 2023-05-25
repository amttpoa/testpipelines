<x-site-layout>
    @section("pageTitle")
    {{ $organization->name }}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl"><a href="{{ route('conference.vendors', $conference) }}">Vendors</a></div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="mx-auto h-max bg-white max-w-4xl p-6">

            <div class="grid sm:grid-cols-3 gap-6 mb-6">
                <div class="sm:col-span-2">
                    <div class="font-medium text-3xl">{{ $organization->name }}</div>
                    <div>{{ $organization->address }}</div>
                    <div>{{ $organization->address2 }}</div>
                    <div>
                        {{ $organization->city ? $organization->city . ',' : '' }}
                        {{ $organization->state }}
                        {{ $organization->zip }}
                    </div>
                    <div>{{ $organization->county }}</div>
                    @if($organization->website)
                    <div class="mt-4">
                        <x-a href="{{ $organization->website }}" target="_blank">Visit Website</x-a>
                    </div>
                    @endif
                </div>
                <div class="text-center">
                    @if($organization->image)
                    <img class="max-h-48 inline" src="{{ Storage::disk('s3')->url('organizations/' . $organization->image) }}" />
                    @endif
                </div>
            </div>

            <div class="prose max-w-full">
                {!! $organization->description !!}
            </div>

        </div>
    </div>

</x-site-layout>