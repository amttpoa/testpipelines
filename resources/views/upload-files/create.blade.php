<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.upload-files.index') }}">Upload Files</x-crumbs.a>
            Add File
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.upload-files.store') }}" enctype="multipart/form-data">
            @csrf
            <x-fields.input-text label="Name" name="name" class="mb-3" />
            <x-fields.input-text label="Description" name="description" class="mb-3" />
            <div class="flex gap-3">
                <x-fields.select label="Folder" name="upload_folder_id" :selections="$folders" class="mb-3" />
                <x-fields.input-text label="Order" type="number" name="order" class="mb-3" />
            </div>
            <x-label>File</x-label>
            <input type="file" name="file" required />
        </form>
    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>