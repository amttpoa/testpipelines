<x-dashboard.layout>
    @section("pageTitle")
    Expenses
    @endSection

    <x-breadcrumbs.holder>
        Expenses
    </x-breadcrumbs.holder>




    @if(auth()->user()->expenses->isNotEmpty())
    <x-dashboard.table class="mb-4">
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Expense For</th>
            <th class="px-2 py-1">Date</th>
            <th class="px-2 py-1 text-right">Total</th>
        </tr>
        @foreach(auth()->user()->expenses as $expense)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1">
                {{ $expense->title }}
            </td>
            <td class="px-2 py-1">
                {{ $expense->date ? $expense->date->format('m/d/Y') : '' }}
            </td>
            <td class="px-2 py-1 text-right">
                ${{ $expense->total ? number_format($expense->total, 2) : '0.00' }}
            </td>
        </tr>
        @endforeach
    </x-dashboard.table>
    @else
    <div class="text-red-900 font-medium text-2xl mb-4">
        You have not submitted any expenses.
    </div>
    @endif


    <x-button-link-site href="{{ route('dashboard.staff.expenses.create') }}">Submit A New Expense</x-button-link-site>

</x-dashboard.layout>