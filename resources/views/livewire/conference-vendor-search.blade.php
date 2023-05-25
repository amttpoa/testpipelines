<div>
    <x-cards.main class="mb-4 flex gap-4">

        <div>
            <x-input name="searchTerm" type="text" placeholder="Search Vendors" wire:model="searchTerm" />
        </div>
        <div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="public" wire:model="public" />Not Public</label>
            </div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="invoiced" wire:model="invoiced" />Not Invoiced</label>
            </div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="paid" wire:model="paid" />Not Paid</label>
            </div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs text-red-700 font-medium"><input value="No" type="checkbox" name="ad" wire:model="ad" />Ad Not Submitted</label>
            </div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="Yes" type="checkbox" name="livefire" wire:model="livefire" />Live Fire</label>
            </div>
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs font-medium"><input value="Yes" type="checkbox" name="comp" wire:model="comp" />Full Comp</label>
            </div>
        </div>
        <div>
            @foreach($radios->where('field', 'sponsorship') as $sponsorship)
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $sponsorship->value }}" type="checkbox" name="sponsorship[]" wire:model="sponsorship" />{{ $sponsorship->value}}</label>
            </div>
            @endforeach
        </div>
        <div>
            @foreach($radios->where('field', 'power') as $power)
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $power->value }}" type="checkbox" name="power[]" wire:model="power" />{{ $power->value}}</label>
            </div>
            @endforeach
        </div>
        <div>
            @foreach($radios->where('field', 'tv') as $tv)
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $tv->value }}" type="checkbox" name="tv[]" wire:model="tv" />{{ $tv->value}}</label>
            </div>
            @endforeach
        </div>
        <div>
            @foreach($radios->where('field', 'internet') as $internet)
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $internet->value }}" type="checkbox" name="internet[]" wire:model="internet" />{{ $internet->value}}</label>
            </div>
            @endforeach
        </div>

    </x-cards.main>

    <x-cards.plain>

        <form method="GET" id="main-form" action="{{ route('admin.vendor-registration-submissions.send-emails', $conference) }}">
            <div class="overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="">
                            <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                <th class="px-2 py-3 w-0" colspan="9"></th>
                                <th class="px-4 py-3">Company</th>
                                <th class="px-4 py-3">Sponsorship</th>
                                <th class="px-4 py-3 text-center">Tables</th>
                                <th class="px-4 py-3 text-center">Lunches</th>
                                <th class="px-4 py-3 text-center">Reps</th>
                                <th class="px-4 py-3 text-center">Total</th>
                                <th class="px-4 py-3">Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-ot-steel">


                            @foreach($submissions as $submission)
                            <tr class="{{ !$submission->public ? 'text-otsteel-400' : '' }} {{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                <td class="px-4 py-3">
                                    @if($submission->user)
                                    <input type="checkbox" class="selectAll" name="vendor_id[]" value="{{ $submission->id }}" />
                                    @endif
                                </td>

                                <td class="pl-2 py-3 w-0">
                                    @if($submission->public)
                                    <i class="fa-solid fa-eye text-xs"></i>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($submission->invoiced)
                                    <i class="fa-solid fa-i"></i>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($submission->paid)
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($submission->advertising)
                                    A
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($submission->comp)
                                    C
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($submission->live_fire == 'Yes')
                                    @if($submission->liveFireSubmission)
                                    <span class="font-black">L</span>
                                    @else
                                    <span class="font-light">L</span>
                                    @endif
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($submission->barter)
                                    @if($submission->barter->completed_user_id)
                                    <span class="font-black">B</span>
                                    @else
                                    <span class="font-light">B</span>
                                    @endif
                                    @endif
                                </td>
                                <td class="pr-2 py-3 w-0">
                                    @if($submission->checked_in)
                                    <i class="fa-solid fa-check"></i>
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex items-center">
                                    <div class="flex-1 font-medium">
                                        <a href="{{ route('admin.vendor-registration-submissions.show', [$submission->conference, $submission]) }}">
                                            {{ $submission->organization ? $submission->organization->name : $submission->company_name }}
                                        </a>
                                    </div>

                                    @if($submission->image)
                                    <div>
                                        <img class="max-h-8 max-w-16" src="{{ Storage::disk('s3')->url('vendor-logos/' . $submission->image) }}" />
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ $submission->sponsorship }}
                                    {{-- - ${{ $submission->sponsorship_price }} --}}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $submission->tables_qty }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $submission->lunch_qty }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $submission->attendees->count() }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    ${{ $submission->total }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $submission->created_at->format('m/d/Y H:i:s') }}
                                    <span class="text-otgray text-sm ml-2">({{ $submission->created_at->diffForHumans() }})</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-4 py-3 border-t border-otsteel">
                <label class="inline-flex items-center justify-start">
                    <input type="checkbox" value="" id="selectAll2" class="mr-2" />
                    select/deselect all
                </label>
            </div>
        </form>

        <div class="p-4">
            {{ $submissions->links() }}
        </div>

        <script>
            $(document).ready(function() {
                    $('#markCheck').click(function() {
                        $('#markType').val('checkedin');
                    });
                    $('#markCompleted').click(function() {
                        $('#markType').val('completed');
                    });
                    $('#selectAll2').change(function() {
                        if($(this).is(":checked")) {
                            $('.selectAll').prop('checked', true);
                        } else {
                            $('.selectAll').prop('checked', false);
                        }      
                    });
                });
        </script>

    </x-cards.plain>
    <div class="flex gap-3 mt-6 ml-6">
        <x-button id="markCheck" form="main-form">Email selected users</x-button>
    </div>

</div>