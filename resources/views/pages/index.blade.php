<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Pages
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.pages.create') }}">Create Page</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.plain>

        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Page</th>
                    <th class="px-4 py-3">Slug</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($pages as $page)
                <tr class=" {{ $loop->index % 2 > 0 ? 'bg-gray-100' : '' }}">
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.pages.edit', $page) }}">{{ $page->name }}</a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('page', $page) }}" target="_blank">{{ $page->slug }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>