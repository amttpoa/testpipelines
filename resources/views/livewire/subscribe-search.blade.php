<div>
    <x-cards.main class="mb-4 flex gap-4 flex-1">

        <div>
            <x-input name="searchTerm" type="text" placeholder="User" wire:model="searchTerm" />
            <div class="mt-4">
                <x-button wire:click.prevent="clear">Clear</x-button>
            </div>
        </div>
        <div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="yes" type="checkbox" wire:model="invoice" />Invoice</label>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="yes" type="checkbox" wire:model="credit" />Credit Card</label>
            </div>
        </div>

    </x-cards.main>


    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Payment Method</th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">
                        @foreach($subscribes as $subscribe)
                        <tr class=" {{ $loop->index % 2 > 0 ? 'bg-gray-100' : '' }}">
                            <td class="px-4 py-3">
                                @if($subscribe->user)
                                <a href="{{ route('admin.users.show', $subscribe->user) }}">
                                    <div class="font-medium">{{ $subscribe->user->name }}</div>
                                    <div class="text-xs">{{ $subscribe->user->email }}</div>
                                </a>
                                @else
                                DELETED USER
                                @endif
                            </td>
                            <td class="px-4 py-3 {{ $subscribe->user ? ($subscribe->email != $subscribe->user->email ? 'text-red-700 font-medium' : '') : '' }}">
                                {{ $subscribe->email }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $subscribe->name }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $subscribe->payment_method }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $subscribe->created_at->format('m/d/Y H:i') }}
                                <div class="text-xs text-otgray">{{ $subscribe->created_at->diffForHumans() }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4">
            {{ $subscribes->links() }}
        </div>
    </x-cards.plain>
</div>