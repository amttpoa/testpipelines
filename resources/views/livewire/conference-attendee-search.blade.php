<div>
    <div class="lg:flex gap-3">
        <x-cards.main class="mb-4 flex gap-4 flex-1">

            <div>
                <x-input name="searchTerm" type="text" placeholder="User" wire:model="searchTerm" />
                <div class="mt-4">
                    {{-- @livewire('organization-autocomplete') --}}
                    <x-input name="organization" type="text" placeholder="Organization" wire:model="organization" />
                </div>
                <div class="mt-4">
                    <x-select name="sort" :selections="['First Name' => 'First Name', 'Last Name' => 'Last Name']" placeholder=" " wire:model="sort" />
                </div>
                <div class="mt-4">
                    <x-button wire:click.prevent="clear">Clear</x-button>
                </div>
            </div>
            <div>
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="membership" wire:model="membership" />No Membership</label>
                </div>
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="No" type="checkbox" name="comp" wire:model="comp" />Full Comp</label>
                </div>
                <div class="mt-4">
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="No" type="checkbox" name="multi_last" wire:model="multi_last" />Multi Last Name</label>
                </div>
            </div>
            <div>
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="yes" type="checkbox" name="invoiced" wire:model="invoiced" />Invoiced</label>
                </div>
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="no" type="checkbox" name="notinvoiced" wire:model="notinvoiced" />Not Invoiced</label>
                </div>
                <div class="mt-4">
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="yes" type="checkbox" name="paid" wire:model="paid" />Paid</label>
                </div>
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="notpaid" wire:model="notpaid" />Not Paid</label>
                </div>
            </div>
            <div>
                @foreach($packages as $package)
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $package->package }}" type="checkbox" name="package[]" wire:model="package" />{{ $package->package}}</label>
                </div>
                @endforeach
            </div>
            <div>
                @foreach($badge_types as $badge_type)
                <div>
                    <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $badge_type->card_type }}" type="checkbox" name="badge_type[]" wire:model="badge_type" />{{ $badge_type->card_type}}</label>
                </div>
                @endforeach
            </div>
        </x-cards.main>
        <x-cards.main class="mb-4 lg:w-96">
            <form method="POST" action="{{ route('admin.conference-attendees.add-attendee', $conference) }}">
                @csrf
                <div>
                    @livewire('user-autocomplete', ['user_id' => '', 'user_name' => ''] )
                </div>
                <div class="mt-4">
                    <x-button>Add Attendee</x-button>
                </div>
            </form>
        </x-cards.main>
    </div>

    <x-cards.plain>

        <form action="{{ route('admin.conference-attendees.badges', $conference) }}" id="main-form" method="POST" class="w-full" target="_blank">
            @csrf
            <div class="overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="">
                            <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                <th class="px-4 py-3" colspan="5"></th>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Organization</th>
                                <th class="px-4 py-3">Package</th>
                                <th class="px-4 py-3">Payer</th>
                                <th class="px-4 py-3 text-center">Courses</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-ot-steel">


                            @foreach ($attendees as $attendee)
                            <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                <td class="px-4 py-3 w-0">
                                    <input type="checkbox" class="selectAll" name="attendee_id[]" wire:model.defer="attendee_id" value="{{ $attendee->id }}" />
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->user)
                                    @if($attendee->user->subscribed())
                                    <span class="font-medium">M</span>
                                    @endif
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->comp)
                                    <span class="font-medium">C</span>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->invoiced)
                                    <i class="fa-solid fa-i"></i>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->paid)
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <a class="flex gap-3 items-center" href="{{ route('admin.conference-attendees.show', [$attendee->conference, $attendee]) }}">
                                        @if($attendee->user)
                                        <div class="w-10">
                                            <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-lg">
                                                {{ $attendee->user->name }}
                                                @if($attendee->user->name != $attendee->card_first_name . ' ' . $attendee->card_last_name)
                                                <span class="text-sm text-otgray ml-4 font-normal">
                                                    {{ $attendee->card_first_name . ' ' . $attendee->card_last_name }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="text-otsteel text-sm">{{ $attendee->user->email }}</div>
                                        </div>
                                        @else
                                        DELETED USER
                                        @endif
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    @if($attendee->user)
                                    @if($attendee->user->organization)
                                    <div>
                                        <a class="font-medium" href="{{ route('admin.organizations.show', $attendee->user->organization) }}">
                                            {{ $attendee->user->organization->name }}
                                        </a>
                                    </div>
                                    @endif
                                    @if($attendee->user->organizations)
                                    @foreach($attendee->user->organizations as $organization)
                                    <div class="leading-tight">
                                        <a class="font-medium text-sm" href="{{ route('admin.organizations.show', $organization) }}">
                                            {{ $organization->name }}
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $attendee->package }} - ${{ $attendee->total }}
                                    <div class="text-xs">
                                        {{ $attendee->created_at->format('m/d/Y H:i') }}
                                        <span class="text-otgray ml-3">{{ $attendee->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-ellipsis overflow-hidden">
                                    {{ $attendee->name }}
                                    <div class="text-xs text-ellipsis overflow-hidden">
                                        {{ $attendee->email }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $attendee->courseAttendees->count() }}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        <div class="p-4">
            {{ $attendees->links() }}
        </div>


        <div class="px-4 py-3 border-t border-otsteel">
            <label class="inline-flex items-center justify-start">
                <input type="checkbox" value="on" wire:change="checkAll" wire:model="check_all" class="mr-2" />
                select/deselect all
            </label>
        </div>

        {{-- <script>
            $(document).ready(function() {
                    $('#selectAll2').change(function() {
                        if($(this).is(":checked")) {
                            $('.selectAll').prop('checked', true);
                        } else {
                            $('.selectAll').prop('checked', false);
                        }      
                    });
                });
        </script> --}}

    </x-cards.plain>


    <div class="flex gap-3">
        <div class="flex gap-3 mt-6 ml-6 items-center" x-data="{ item: '' }">
            <div>
                Mark selected as
            </div>
            <x-select name="not" wire:model="not" :selections="['' => '', 'NOT' => 'NOT']" />
            <x-select name="item" x-model="item" wire:model="item" :selections="['' => '', 'full comp' => 'full comp', 'invoiced' => 'invoiced', 'paid' => 'paid', 'checked in' => 'checked in', 'completed' => 'completed']" />
            <button :disabled="!item" wire:click.prevent="formSubmit" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150">
                Submit
            </button>
        </div>



        <div class="flex gap-3 mt-6 ml-6 items-center" x-data="{ item: '' }">
            <div>
                Badges
            </div>
            <x-select name="item" form="main-form" x-model="item" wire:model="item" :selections="['' => '', 'View Badges' => 'View Badges', 'PDF Badges' => 'PDF Badges']" />
            <button :disabled="!item" form="main-form" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150">
                Submit
            </button>
        </div>
    </div>

</div>