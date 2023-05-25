<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Upload File
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.upload-files.create') }}">Add File</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <h2 class="font-medium text-2xl mb-4">Upload Files</h2>
        <div>
            @foreach($folders as $folder)
            <div class="text-xl font-medium mb-3">
                {{ $folder->name }}
                <span class="ml-4">{{ $folder->restriction }}</span>
            </div>
            <div class="mb-6">

                <x-admin.table>
                    <tbody class="bg-white divide-y divide-ot-steel">

                        @foreach($folder->uploadFiles as $file)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                            <td class="px-4 py-1">
                                <a class="font-medium" href="{{ route('admin.upload-files.edit', $file) }}">{{ $file->name }}</a>
                            </td>
                            <td class="px-4 py-1 w-0">
                                <a href="{{ Storage::disk('s3')->url('uploads/share/' . $file->file_name) }}" target="_blank">
                                    Download
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </x-admin.table>
            </div>
            @endforeach
        </div>
    </x-cards.main>

</x-app-layout>