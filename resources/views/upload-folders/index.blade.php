<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Upload Folders
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.upload-folders.create') }}">Create Folder</x-button-link>
        </div>
    </x-crumbs.bar>


    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Folder</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Restriction</th>
                    <th class="px-4 py-3">Order</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">

                @foreach($folders as $folder)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1">
                        <a href="{{ route('admin.upload-folders.edit', $folder) }}">
                            {{ $folder->name }}
                        </a>
                    </td>
                    <td class="px-4 py-1">
                        {{ $folder->description }}
                    </td>
                    <td class="px-4 py-1">
                        {{ $folder->restriction }}
                    </td>
                    <td class="px-4 py-1">
                        {{ $folder->order }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>




</x-app-layout>