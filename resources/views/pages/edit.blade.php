<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.pages.index') }}">Pages</x-crumbs.a>
            Edit Page
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.pages.update', $page) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Name" name="name" class="mb-3" value="{{ $page->name }}" />

            <div class="">
                <x-label for="content">Content</x-label>
                <x-textarea rows="5" class="addTiny" name="content">{{ $page->content }}</x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>