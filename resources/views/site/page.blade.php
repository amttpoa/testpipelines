<x-site-layout>
    @section("pageTitle")
    {{ $page->name }}
    @endSection

    <div class="bg-otgray text-white">
        <div class="px-10 py-4 max-w-7xl mx-auto">
            <div class="font-semibold text-3xl font-blender text-center">
                {{ $page->name }}
            </div>
        </div>
    </div>

    <div class="flex-1 bg-otsteel">
        <div class="max-w-5xl bg-white mx-auto p-6 py-12 prose sponsorships">

            {!! $page->content !!}

        </div>
    </div>
</x-site-layout>