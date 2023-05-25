<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Faq Categories
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.faqCategories.create') }}">Create Category</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <h2 class="font-medium text-2xl mb-4">Faq Categories</h2>
        <div>
            @foreach($categories as $category)
            <div>
                <a href="{{ route('admin.faqCategories.edit', $category) }}">
                    {{ $category->category }}
                </a>
            </div>
            @endforeach
        </div>
    </x-cards.main>

</x-app-layout>