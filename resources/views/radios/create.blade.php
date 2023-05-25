<x-app-layout>
    <div class="flex items-center gap-4 mb-4">
        <div class="flex-1 flex items-center gap-2 font-semibold text-base text-gray-500">
            <a class="text-black flex items-center gap-2" href={{ route('admin.dashboard') }}>
                <i class="fa-solid fa-house text-sm"></i> Home
            </a>
            <i class="fa-solid fa-angle-right text-sm"></i>
            <a href="{{ route('admin.faqs.index') }}" class="text-black">Faqs</a>
            <i class="fa-solid fa-angle-right text-sm"></i>
            Create Faq
        </div>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </div>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.faqs.store') }}">
            @csrf

            <x-fields.input-text label="Question" name="question" class="mb-3" />
            <div class="mb-3">
                <x-label for="answer">Answer</x-label>
                <x-textarea id="answer" name="answer" class="addTiny"></x-textarea>
            </div>

            <x-fields.select label="Category" name="faq_category_id" :selections="$categories" class="mb-3" />
            <x-fields.input-text label="Order" type="number" name="order" class="mb-3" />

        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>