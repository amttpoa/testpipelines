<div>
    <x-cards.main class="mb-4 flex gap-4">

        <div>
            <x-input name="searchTerm" type="text" placeholder="Search Organizations" wire:model="searchTerm" />
        </div>
        <div>
            <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="Customer" type="checkbox" name="organization_type" wire:model="organization_type" />Customer</label>
        </div>
        <div>
            <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="Vendor" type="checkbox" name="organization_type" wire:model="organization_type" />Vendor</label>
        </div>

    </x-cards.main>

    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-left bg-otsteel text-white divide-x divide-white">
                            <th class="px-4 py-3 font-normal">Name</th>
                            <th class="px-4 py-3 font-normal">Type</th>
                            <th class="px-4 py-3 font-normal">Users</th>
                            <th class="px-4 py-3 font-normal">Domain</th>
                            <th class="px-4 py-3 font-normal">City</th>
                            <th class="px-4 py-3 font-normal">State</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-otsteel">
                        @foreach ($organizations as $organization)
                        <tr>
                            <td class="px-4 py-3">
                                <a class="font-medium" href="{{ route('admin.organizations.show', $organization) }}">
                                    {{ $organization->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $organization->organization_type }}</td>
                            <td class="px-4 py-3 text-center">{{ $organization->primaryUsers->count() }}</td>
                            <td class="px-4 py-3">{{ $organization->domain }}</td>
                            <td class="px-4 py-3">{{ $organization->city }}</td>
                            <td class="px-4 py-3">{{ $organization->state }}</td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>



        <div class="p-6">
            {{ $organizations->links() }}
        </div>

    </x-cards.plain>
</div>