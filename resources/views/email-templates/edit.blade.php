<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.email-templates.index') }}">Email Templates</x-crumbs.a>
            Edit Template
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.email-templates.update', $emailTemplate) }}">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-3">
                <x-fields.input-text label="Name" name="name" value="{{ $emailTemplate->name }}" class="mb-3" />
                <x-fields.input-text label="Code" name="code" value="{{ $emailTemplate->code }}" class="mb-3" />
            </div>
            <x-fields.input-text label="Description" name="description" value="{!! $emailTemplate->description !!}" class="mb-3" />
            <x-fields.input-text label="Subject" name="subject" value="{!! $emailTemplate->subject !!}" class="mb-3" />
            <div class="mb-3">
                <x-label for="body">Body</x-label>
                <x-textarea id="body" name="body" class="addTiny">{{ $emailTemplate->body }}</x-textarea>
            </div>
        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>