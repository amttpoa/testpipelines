<x-dashboard.layout>
    @section("pageTitle")
    Files
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.upload-files.folders') }}">Files</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.upload-files.index', $uploadFolder) }}">{{ $uploadFolder->name }}</a>
        <x-breadcrumbs.arrow />
        {{ $uploadFile->file_name }}
    </x-breadcrumbs.holder>

    @can('staff-instructor')
    <div class="">
        <div class="mb-4 text-lg">
            File:
            <span class="font-medium">{{ $uploadFile->file_name }}</span>
        </div>

        <form method="POST" id="main-form" action="{{ route('dashboard.upload-files.update', [$uploadFolder, $uploadFile]) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <x-fields.input-text label="Name" name="name" value="{{ $uploadFile->name }}" class="mb-3" required />
            <x-fields.input-text label="Description" name="description" value="{{ $uploadFile->description }}" class="mb-3" />
        </form>

        <div class="mt-6">
            <x-button-site form="main-form">Update File Info</x-button-site>
        </div>
    </div>
    @endcan

</x-dashboard.layout>