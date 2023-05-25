<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.upload-files.index') }}">Upload Files</x-crumbs.a>
            Edit File
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.upload-files.destroy',  $uploadFile) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete File</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <x-form-errors />
        <div class="font-medium text-xl mb-4">{{ $uploadFile->file_name }}</div>

        <form method="POST" id="main-form" action="{{ route('admin.upload-files.update', $uploadFile) }}">
            @csrf
            @method('PATCH')
            <x-fields.input-text label="Name" name="name" value="{{ $uploadFile->name }}" class="mb-3" />
            <x-fields.input-text label="Description" name="description" value="{{ $uploadFile->description }}" class="mb-3" />
            <div class="flex gap-3">
                <x-fields.select label="Folder" name="upload_folder_id" :selections="$folders" :selected="$uploadFile->folder_id" class="mb-3" />
                <x-fields.input-text label="Order" type="number" name="order" value="{{ $uploadFile->order }}" class="mb-3" />
            </div>
        </form>
    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>