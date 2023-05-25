<x-dashboard.layout>
    @section("pageTitle")
    Files
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.upload-files.folders') }}">Files</a>
        <x-breadcrumbs.arrow />
        {{ $uploadFolder->name }}
    </x-breadcrumbs.holder>


    <div class="grid md:grid-cols-2 gap-4">
        @foreach($uploadFolder->uploadFiles as $file)
        <div>
            <a href="{{ Storage::disk('s3')->url('uploads/share/' . $file->file_name) }}" target="_blank">
                <div class="border border-otgray-300 rounded-xl p-4 flex items-center gap-3 hover:bg-otgray-50">
                    <div class="w-16">
                        @if($file->file_ext == 'xls' || $file->file_ext == 'xlsx')
                        <img src="/img/files/xls.svg" class="w-16" />
                        @elseif($file->file_ext == 'doc' || $file->file_ext == 'docx')
                        <img src="/img/files/doc.svg" class="w-16" />
                        @elseif($file->file_ext == 'ppt' || $file->file_ext == 'pptx')
                        <img src="/img/files/ppt.svg" class="w-16" />
                        @elseif($file->file_ext == 'pdf')
                        <img src="/img/files/pdf.svg" class="w-16" />
                        @elseif($file->file_ext == 'mov')
                        <img src="/img/files/mov.svg" class="w-16" />
                        @else
                        <div class="text-center text-2xl font-bold text-otgray-200">
                            {{ $file->file_ext }}
                        </div>
                        {{--
                        <x-icons.question class="w-16 h-16 text-otgray-200" /> --}}
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-xl">{{ $file->name }}</div>
                        <div class="text-xs font-light text-otgray">{{ $file->file_name }}</div>
                        <div class="text-otgray">{{ $file->description }}</div>
                    </div>
                </div>
            </a>
            @if($file->user_id == auth()->user()->id)
            <div class="flex gap-2 text-xs mx-2">
                <div class="flex-1">You uploaded this file on {{ $file->created_at->format('m/d/Y') }}</div>
                <div>
                    <a class="font-medium" href="{{ route('dashboard.upload-files.edit', [$uploadFolder, $file]) }}">Edit</a>
                </div>
                <div>
                    <form method="POST" action="{{ route('dashboard.upload-files.destroy',  $file) }}" onsubmit="return confirm('Are you sure you want to delete this upload?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-800 font-medium">Delete</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        @endforeach
    </div>

    @can('staff-instructor')
    <div class="max-w-xl">
        <div class="mt-8 mb-4 text-2xl font-medium">Upload file to {{ $uploadFolder->name }}</div>

        <form method="POST" id="main-form" action="{{ route('dashboard.upload-files.store', $uploadFolder) }}" enctype="multipart/form-data">
            @csrf
            <x-fields.input-text label="Name" name="name" class="mb-3" />
            <x-fields.input-text label="Description" name="description" class="mb-3" />
            <x-label>File</x-label>
            <input type="file" name="file" required />
        </form>

        <div class="mt-6">
            <x-button-site form="main-form">Upload File</x-button-site>
        </div>
    </div>
    @endcan

</x-dashboard.layout>