<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Reimbursements
        </x-crumbs.holder>
    </x-crumbs.bar>

    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($conference->reimbursements->sortByDesc('created_at') as $request)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('admin.reimbursements.show', [$conference, $request]) }}">
                            {{ $request->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $request->status }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        ${{ number_format($request->total, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>