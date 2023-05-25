<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.faqs.index') }}">Faqs</x-crumbs.a>
            Edit Faq
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Question" name="question" value="{!! $faq->question !!}" class="mb-3" />
            <div class="mb-3">
                <x-label for="answer">Answer</x-label>
                <x-textarea id="answer" name="answer" class="addTiny">{{ $faq->answer }}</x-textarea>
            </div>

            <x-fields.select label="Category" name="faq_category_id" :selections="$categories" :selected="$faq->faq_category_id" class="mb-3" />
            <x-fields.input-text label="Order" type="number" name="order" value="{{ $faq->order }}" class="mb-3" />

        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>