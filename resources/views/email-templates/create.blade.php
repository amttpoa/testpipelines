<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.email-templates.index') }}">Email Templates</x-crumbs.a>
            Create Template
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.email-templates.store') }}">
            @csrf

            <x-fields.input-text label="Name" name="name" class="mb-3" />
            <x-fields.input-text label="Code" name="code" class="mb-3" />
            <x-fields.input-text label="Description" name="description" class="mb-3" />
            <x-fields.input-text label="Subject" name="subject" class="mb-3" />
            <div class="mb-3">
                <x-label for="body">Body</x-label>
                <x-textarea id="body" name="body" class="addTiny"></x-textarea>
            </div>
        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>