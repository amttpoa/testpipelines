<div>
    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3" colspan="2"></th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Organization</th>
                            <th class="px-4 py-3">Comments</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">


                        @foreach($eventAttendees->sortBy('user.name') as $attendee)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                            <td class="px-4 py-3 w-0">
                                <input type="checkbox" class="selectAll" name="attendee_id[]" wire:model.defer="attendee_id" value="{{ $attendee->id }}" />
                            </td>
                            <td class="py-3 w-0">
                                @if($attendee->checked_in)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($attendee->user)
                                <a href="{{ route('admin.event-attendees.show', [$attendee->event, $attendee]) }}">
                                    <div class="flex gap-3 items-center">
                                        <div class="w-10">
                                            <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-lg">{{ $attendee->user->name }}</div>
                                            <div class="text-otsteel text-sm">{{ $attendee->user->email }}</div>
                                        </div>
                                    </div>
                                </a>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium">
                                @if($attendee->user)
                                @if($attendee->user->organization)
                                <div class="">
                                    <a href="{{ route('admin.organizations.show', $attendee->user->organization) }}">
                                        {{ $attendee->user->organization->name }}
                                    </a>
                                </div>
                                @foreach($attendee->user->organizations as $organization)
                                <div class="text-sm">
                                    <a class="sm" href="{{ route('admin.organizations.show', $organization) }}">
                                        {{ $organization->name }}
                                    </a>
                                </div>
                                @endforeach
                                @endif
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ $attendee->comments }}
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="px-4 py-3 border-t border-otsteel">
            <label class="inline-flex items-center justify-start">
                <input type="checkbox" value="on" wire:change="checkAll" wire:model="check_all" class="mr-2" />
                select/deselect all
            </label>
        </div>


    </x-cards.plain>

    <div class="flex gap-3">
        <div class="flex gap-3 mt-6 ml-6 items-center" x-data="{ item: '' }">
            <div>
                Mark selected as
            </div>
            <x-select name="not" wire:model="not" :selections="['' => '', 'NOT' => 'NOT']" />
            <x-select name="item" x-model="item" wire:model="item" :selections="['' => '', 'checked in' => 'checked in']" />
            <button :disabled="!item" wire:click.prevent="formSubmit" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150">
                Submit
            </button>
        </div>

    </div>

</div>