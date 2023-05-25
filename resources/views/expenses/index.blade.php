<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Expenses
        </x-crumbs.holder>
    </x-crumbs.bar>


    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">For</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3">Submitted</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($expenses as $expense)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('admin.expenses.show', $expense) }}">
                            {{ $expense->title }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $expense->date ? $expense->date->format('m/d/Y') : '' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $expense->location }}
                    </td>
                    <td class="px-4 py-3 flex gap-2 items-center">
                        <x-profile-image :profile="$expense->user->profile" class="w-8 h-8" />
                        {{ $expense->user->name }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        ${{ number_format($expense->total, 2) }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $expense->created_at->format('m/d/y H:i:s') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>


    {{ $expenses->links() }}

</x-app-layout>