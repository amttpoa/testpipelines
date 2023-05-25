<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Awards
        </x-crumbs.holder>
    </x-crumbs.bar>

    <x-cards.main>
        @foreach($awards as $award)
        <div>
            <a href="{{ route('admin.awards.edit', $award) }}">
                {{ $award->name }}
            </a>
        </div>
        @endforeach

    </x-cards.main>

</x-app-layout>