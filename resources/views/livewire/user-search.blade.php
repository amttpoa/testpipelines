<div>
    <form method="GET" id="main-form" action="{{ route('admin.users.export') }}">
        <x-cards.main class="mb-4 md:flex md:gap-4">

            <div>
                <x-input name="searchTerm" type="text" placeholder="Search Users" wire:model="searchTerm" />
                <div class="flex mt-2 items-center">
                    <div class="flex-1">
                        <div class="">
                            {{ $users->total() }} Total
                        </div>
                    </div>
                    <div>
                        <x-button wire:click.prevent="clear">Clear</x-button>
                    </div>
                </div>
            </div>
            <div class="columns-2 md:columns-5 gap-3">
                @foreach($roles as $role)
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $role->name }}" type="checkbox" name="role[]" wire:model="role" />{{ $role->name}}</label>
                </div>
                @endforeach
            </div>

            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="no_org" wire:model="noOrg" />No Organization</label>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="no_sub" wire:model="noSub" />No Membership</label>
                {{-- <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="No" type="checkbox" name="yes_sub" wire:model="sub" />Membership</label> --}}
            </div>
            <div class="flex-1 text-right">
                <x-button>Export</x-button>
            </div>

        </x-cards.main>
    </form>

    <x-cards.plain>


        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Organization</th>
                            <th class="px-4 py-3">Plan</th>
                            <th class="px-4 py-3">Roles</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">


                        @foreach ($users as $user)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                            <td class="px-4 py-3">
                                <a class="flex gap-3 items-center" href="{{ route('admin.users.show', $user) }}">
                                    <div class="w-10">
                                        <x-profile-image class="w-10 h-10" :profile="$user->profile" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-lg">{{ $user->name }}</div>
                                        <div class="text-otsteel text-sm">{{ $user->email }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                @if($user)
                                @if($user->organization)
                                <div>
                                    <a class="font-medium" href="{{ route('admin.organizations.show', $user->organization) }}">
                                        {{ $user->organization->name }}
                                    </a>
                                </div>
                                @endif
                                @if($user->organizations)
                                @foreach($user->organizations as $organization)
                                <div class="leading-tight">
                                    <a class="font-medium text-sm" href="{{ route('admin.organizations.show', $organization) }}">
                                        {{ $organization->name }}
                                    </a>
                                </div>
                                @endforeach
                                @endif
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($user->subscription())
                                {{ $user->subscription()->authorize_plan }}
                                {{-- @foreach ($user->subscription->where('stripe_status', 'active') as $subscription) --}}
                                {{-- {{ $subscription->stripe_price == 'price_1LPgSzCh7AUlZv8XR90BuZVa' ? 'Standard' : '' }}
                                {{ $subscription->stripe_price == 'price_1LPgTiCh7AUlZv8XtAuLMZa5' ? 'Retired' : '' }}
                                {{ $subscription->stripe_price == 'price_1LQ0SCCh7AUlZv8XTPDswVcm' ? 'Civilian' : '' }}
                                {{ $subscription->stripe_price == 'price_1LQ0T7Ch7AUlZv8X4sCAagQj' ? 'Corporate' : '' }} --}}
                                {{-- {{ $plans->where('stripe_plan', $subscription->stripe_price)->first()->slug }} --}}
                                {{-- @endforeach --}}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <x-user-roles :user="$user" />
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.users.edit',$user->id) }}">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-4">
            {{ $users->links() }}
        </div>

    </x-cards.plain>
</div>