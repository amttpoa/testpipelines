<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Faqs
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.faqs.create') }}">Create Faq</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <h2 class="font-medium text-2xl mb-4">Faqs</h2>
        <div>
            @foreach($categories as $category)
            <div class="text-xl font-medium mb-3">{{ $category->category }}</div>
            <div class="mb-6">
                @foreach($category->faqs as $faq)
                <div>
                    <a href="{{ route('admin.faqs.edit', $faq) }}">
                        {{ $faq->question }}
                    </a>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </x-cards.main>

</x-app-layout>