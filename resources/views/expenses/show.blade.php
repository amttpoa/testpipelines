<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.expenses.index') }}">Expenses</x-crumbs.a>
            {{ $expense->user->name }}
        </x-crumbs.holder>
    </x-crumbs.bar>


    <div class="grid xl:grid-cols-2 gap-6 mb-6">
        <x-cards.main>
            <div class="font-medium text-2xl">
                {{ $expense->title }}
            </div>
            <div class="font-medium text-2xl">
                ${{ number_format($expense->total, 2) }}
            </div>
            <div>
                {{ $expense->payer }}
            </div>
            <div>
                {{ $expense->card }}
            </div>
            <div>
                {{ $expense->date ? $expense->date->format('m/d/Y') : '' }}
            </div>
            <div>
                {{ $expense->location }}
            </div>
            <div>
                {{ $expense->user->name }}
            </div>
            <div>
                {{ $expense->comments }}
            </div>
            <div>
                @foreach($expense->expenseUploads as $upload)
                <div>
                    <a href="{{ Storage::disk('s3')->url('expenses/' . $upload->file_name) }}" target="_blank">
                        {{ $upload->file_name }}
                    </a>

                </div>
                @endforeach
            </div>
        </x-cards.main>
        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\Expense', 'subject_id' => $expense->id])
        </x-cards.main>

    </div>


    <x-cards.plain class="mb-6">
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Item</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3">Comment</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">

                @foreach($expense->expenseItems as $item)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1">
                        {{ $item->name }}
                    </td>
                    <td class="px-4 py-1 text-right">
                        ${{ $item->price ? number_format($item->price, 2) : '0.00' }}
                    </td>
                    <td class="px-4 py-1">
                        {{ $item->comments }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>



</x-app-layout>