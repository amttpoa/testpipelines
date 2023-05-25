<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.faqCategories.index') }}">Faq Categories</x-crumbs.a>
            Create Faq Category
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.faqCategories.store') }}">
            @csrf

            <x-fields.input-text label="Category" name="category" class="mb-3" />
            <x-fields.input-text label="Order" type="number" name="order" class="mb-3" />

        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>