<x-site-layout>
    @section("pageTitle")
    Awards
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">Awards</div>
    </x-banner>

    <div class="bg-otsteel">
        <div class="max-w-4xl p-6 sm:px-10 bg-white mx-auto">
            <div class="text-lg mb-10">
                <div class="mb-5">The OTOA wants to acknowledge tactically minded first responders and individuals who exhibit commitment, expertise, enthusiasm, support, and/or valorous actions.</div>
                <div class="mb-5">Any person can nominate an individual or group who qualifies for recognition.</div>
                <div class="mb-5">An awards committee selected by the OTOA board of directors will make the final decision regarding the recipient(s) of the awards.</div>
            </div>

            @foreach($awards as $award)
            <a href="{{ route('awards.show', $award ) }}" class="flex gap-10 items-center mb-6">
                <div>
                    <img class="w-40 h-40 object-contain" src="/img/awards/{{ $award->image }}" />
                </div>
                <div class="flex-1">
                    <div class="font-medium text-3xl">{{ $award->name }}</div>
                    <div class="text-lg prose max-w-full">{!! $award->short_description !!}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>


</x-site-layout>