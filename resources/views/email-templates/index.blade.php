<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Email Templates
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.email-templates.create') }}">Create Template</x-button-link>
        </div>
    </x-crumbs.bar>


    <x-cards.plain>

        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Description</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($templates as $template)
                <tr>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.email-templates.edit', $template) }}">
                            {{ $template->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.email-templates.edit', $template) }}">
                            {{ $template->subject }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.email-templates.edit', $template) }}">
                            {{ $template->description }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>