<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Staff
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.staffs.create') }}">Create Staff</x-button-link>
        </div>
    </x-crumbs.bar>


    <x-cards.plain>

        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Section</th>
                    <th class="px-4 py-3">Order</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($staffs as $section)
                @foreach($section as $staff)
                <tr class="border-t border-otsteel {{ $loop->parent->index % 2 > 0 ? 'bg-otgray-50' : '' }} ">

                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('admin.staffs.edit', $staff) }}">
                            {{ $staff->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $staff->title }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $staff->staffSection->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $staff->order }}
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>