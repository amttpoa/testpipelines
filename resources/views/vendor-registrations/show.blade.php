<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.vendor-registration-submissions.index', $vendorRegistrationSubmission->conference) }}">Vendors</x-crumbs.a>
            {{ $vendorRegistrationSubmission->organization->name }}
        </x-crumbs.holder>
        <x-page-menu>
            @if(!$vendorRegistrationSubmission->barter)
            <form method="POST" action="{{ route('admin.vendor-registration-submissions.add-barter',  [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}">
                @csrf
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Add Barter</button>
            </form>
            @endif
            <a href="{{ route('admin.vendor-registration-submissions.print', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">Print</a>
            <form method="POST" action="{{ route('admin.vendor-registration-submissions.destroy',  [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
            <a href="{{ route('admin.vendor-registration-submissions.view-badge', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Badges</a>
            <a href="{{ route('admin.vendor-registration-submissions.pdf-badge', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank" download>PDF Badges</a>
        </x-page-menu>
        <div>
            <x-button-link href="{{ route('admin.vendor-registration-submissions.edit', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}">Edit Submission</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid lg:grid-cols-2 gap-6">
        <div>

            @if($vendorRegistrationSubmission->organization)
            <x-cards.organization class="mb-6" :organization="$vendorRegistrationSubmission->organization" />
            @endif


            <x-cards.main class="">
                <div>
                    Submitted by:
                    @if($vendorRegistrationSubmission->user)
                    <x-a href="{{ route('admin.users.show', $vendorRegistrationSubmission->user) }}">{{ $vendorRegistrationSubmission->user->name }}</x-a>
                    @else
                    Unknown
                    @endif
                    on
                    {{ $vendorRegistrationSubmission->created_at->format('m/d/Y H:i:s') }}
                    <span class="text-otgray text-sm ml-2">({{ $vendorRegistrationSubmission->created_at->diffForHumans() }})</span>
                </div>
                <div class="font-medium text-xl mt-2">{{ $vendorRegistrationSubmission->sponsorship }} - ${{ $vendorRegistrationSubmission->sponsorship_price }}</div>

                <table class="mt-6">
                    <tr>
                        <td class="font-medium text-right pr-2">Live Fire:</td>
                        <td>{{ $vendorRegistrationSubmission->live_fire }} - ${{ $vendorRegistrationSubmission->live_fire_price }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Lunch:</td>
                        <td>
                            @if($vendorRegistrationSubmission->lunch)
                            {{ $vendorRegistrationSubmission->lunch }} - ${{ $vendorRegistrationSubmission->lunch_price }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Power:</td>
                        <td>{{ $vendorRegistrationSubmission->power }} - ${{ $vendorRegistrationSubmission->power_price }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">TV:</td>
                        <td>
                            @if($vendorRegistrationSubmission->tv)
                            {{ $vendorRegistrationSubmission->tv }} - ${{ $vendorRegistrationSubmission->tv_price }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Internet:</td>
                        <td>{{ $vendorRegistrationSubmission->internet }} - ${{ $vendorRegistrationSubmission->internet_price }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Tables:</td>
                        <td>{{ $vendorRegistrationSubmission->tables }} - ${{ $vendorRegistrationSubmission->tables_price }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Total:</td>
                        <td>${{ $vendorRegistrationSubmission->total }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Lunch Qty:</td>
                        <td>{{ $vendorRegistrationSubmission->lunch_qty }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Tables Qty:</td>
                        <td>{{ $vendorRegistrationSubmission->tables_qty }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Comments:</td>
                        <td>{{ $vendorRegistrationSubmission->comments }}</td>
                    </tr>
                </table>

                <div class="mt-8 flex gap-6 flex-wrap">
                    <div>
                        <div class="font-medium text-xl">Advertising</div>
                        <div>{{ $vendorRegistrationSubmission->advertising_name }}</div>
                        <div><a href="mailto:{{ $vendorRegistrationSubmission->advertising_email }}" target="_blank">{{ $vendorRegistrationSubmission->advertising_email }}</a></div>
                        <div>{{ $vendorRegistrationSubmission->advertising_phone }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-xl">Live Fire</div>
                        <div>{{ $vendorRegistrationSubmission->live_fire_name }}</div>
                        <div><a href="mailto:{{ $vendorRegistrationSubmission->live_fire_email }}" target="_blank">{{ $vendorRegistrationSubmission->live_fire_email }}</a></div>
                        <div>{{ $vendorRegistrationSubmission->live_fire_phone }}</div>
                    </div>
                    <div class="hidden">
                        <div class="font-medium text-xl">Primary</div>
                        <div>{{ $vendorRegistrationSubmission->primary_name }}</div>
                        <div><a href="mailto:{{ $vendorRegistrationSubmission->primary_email }}" target="_blank">{{ $vendorRegistrationSubmission->primary_email }}</a></div>
                        <div>{{ $vendorRegistrationSubmission->primary_phone }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-xl">Billing</div>
                        <div>{{ $vendorRegistrationSubmission->billing_name }}</div>
                        <div><a href="mailto:{{ $vendorRegistrationSubmission->billing_email }}" target="_blank">{{ $vendorRegistrationSubmission->billing_email }}</a></div>
                        <div>{{ $vendorRegistrationSubmission->billing_phone }}</div>
                    </div>
                </div>


                <div class="mt-8 flex gap-6 flex-wrap">
                    @foreach($vendorRegistrationSubmission->attendees as $attendee)
                    <div>
                        <div class="font-medium text-xl">Rep {{ $loop->index + 1 }}</div>
                        <div>{{ $attendee->name }}</div>
                        <div><a href="mailto:{{ $attendee->email }}" target="_blank">{{ $attendee->email }}</a></div>
                        <div>{{ $attendee->phone }}</div>
                    </div>
                    @endforeach
                </div>

            </x-cards.main>
        </div>


        <div>
            <form method="POST" id="main-form" action="{{ route('admin.vendor-registration-submissions.update', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <x-cards.main class="mb-6">
                    <div class="flex gap-6">
                        <div class="">
                            <label class="flex gap-3 items-center">
                                <input type="checkbox" name="public" value="1" {{ $vendorRegistrationSubmission->public ? 'checked' : '' }} />
                                Public
                            </label>
                            <label class="flex gap-3 items-center">
                                <input type="checkbox" name="advertising" value="1" {{ $vendorRegistrationSubmission->advertising ? 'checked' : '' }} />
                                Advertising Received
                            </label>
                        </div>
                        <div>
                            <label class="flex gap-3 items-center">
                                <input type="checkbox" name="invoiced" value="1" {{ $vendorRegistrationSubmission->invoiced ? 'checked' : '' }} />
                                Invoiced
                            </label>
                            <label class="flex gap-3 items-center">
                                <input type="checkbox" name="paid" value="1" {{ $vendorRegistrationSubmission->paid ? 'checked' : '' }} />
                                Paid
                            </label>
                        </div>
                        <div>
                            <label class="flex gap-3 items-center">
                                <input type="checkbox" name="comp" value="1" {{ $vendorRegistrationSubmission->comp ? 'checked' : '' }} />
                                Full Comp
                            </label>
                            <label class="flex gap-3 items-center">
                                <input type="checkbox" name="checked_in" value="1" {{ $vendorRegistrationSubmission->checked_in ? 'checked' : '' }} />
                                Checked In
                            </label>
                        </div>
                        <div>
                            <x-button>Save</x-button>
                        </div>
                    </div>
                </x-cards.main>
            </form>

            @if($vendorRegistrationSubmission->barter)
            <form method="POST" id="main-form" action="{{ route('admin.vendor-registration-submissions.update-barter', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}">
                @csrf
                @method('PATCH')
                <x-cards.main class="mb-6">
                    <h2 class="text-2xl mb-4">Barter Form</h2>
                    <x-textarea class="mb-4" rows="5" name="comments">{!! $vendorRegistrationSubmission->barter->comments !!}</x-textarea>
                    <x-button>Save</x-button>
                </x-cards.main>
            </form>
            @endif

            @if($vendorRegistrationSubmission->liveFireSubmission)
            <x-cards.main class="mb-6">

                <h2 class="text-2xl mb-4">Live Fire Form</h2>

                <table class="">
                    <tr>
                        <td class="font-medium text-right pr-2">Bringing:</td>
                        <td>{{ $vendorRegistrationSubmission->liveFireSubmission->bringing }}</td>
                    </tr>
                    @if($vendorRegistrationSubmission->liveFireSubmission->firearm)
                    <tr>
                        <td class="font-medium text-right pr-2">Firearm:</td>
                        <td>{{ $vendorRegistrationSubmission->liveFireSubmission->firearm }}</td>
                    </tr>
                    @endif
                    @if($vendorRegistrationSubmission->liveFireSubmission->caliber)
                    <tr>
                        <td class="font-medium text-right pr-2">Caliber:</td>
                        <td>{{ $vendorRegistrationSubmission->liveFireSubmission->caliber }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="font-medium text-right pr-2">Share:</td>
                        <td>
                            {{ $vendorRegistrationSubmission->liveFireSubmission->share }}
                            @if($vendorRegistrationSubmission->liveFireSubmission->share == 'Yes')
                            - {{ $vendorRegistrationSubmission->liveFireSubmission->share_with }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium text-right pr-2">Description:</td>
                        <td>{{ $vendorRegistrationSubmission->liveFireSubmission->description }}</td>
                    </tr>
                </table>

                <div class="mt-4">
                    Submitted by:
                    @if($vendorRegistrationSubmission->liveFireSubmission->user)
                    <x-a href="{{ route('admin.users.show', $vendorRegistrationSubmission->liveFireSubmission->user) }}">{{ $vendorRegistrationSubmission->liveFireSubmission->user->name }}</x-a>
                    @else
                    Unknown
                    @endif
                    on
                    {{ $vendorRegistrationSubmission->liveFireSubmission->created_at->format('m/d/Y H:i:s') }}
                    <span class="text-otgray text-sm ml-2">({{ $vendorRegistrationSubmission->liveFireSubmission->created_at->diffForHumans() }})</span>
                </div>

            </x-cards.main>
            @endif


            <x-cards.main>
                @livewire('notes', ['subject_type' => 'App\Models\VendorRegistrationSubmission', 'subject_id' => $vendorRegistrationSubmission->id])
            </x-cards.main>




        </div>

    </div>

</x-app-layout>