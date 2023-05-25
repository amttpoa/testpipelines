<x-dashboard.layout>
    @section("pageTitle")
    Membership Benefits
    @endSection

    <x-breadcrumbs.holder>
        Membership Benefits
    </x-breadcrumbs.holder>

    <div class="prose max-w-full">
        {!! $page->content !!}
    </div>

</x-dashboard.layout>