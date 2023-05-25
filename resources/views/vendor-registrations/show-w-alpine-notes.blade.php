<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.vendor-registration-submissions.index', $vendorRegistrationSubmission->conference) }}">Vendors</x-crumbs.a>
            {{ $vendorRegistrationSubmission->organization->name }}
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.vendor-registration-submissions.print', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">Print</a>
            <form method="POST" action="{{ route('admin.vendor-registration-submissions.destroy',  [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
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
                    <x-a href="{{ route('admin.users.show', $vendorRegistrationSubmission->user) }}">{{ $vendorRegistrationSubmission->user->name }}</x-a>
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


        <form method="POST" id="main-form" x-data="formHandler()" action="{{ route('admin.vendor-registration-submissions.update', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-cards.main class="mb-6">

                <div class="flex gap-6">
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="public" value="1" {{ $vendorRegistrationSubmission->public ? 'checked' : '' }} />
                        Public
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="paid" value="1" {{ $vendorRegistrationSubmission->paid ? 'checked' : '' }} />
                        Paid
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="advertising" value="1" {{ $vendorRegistrationSubmission->advertising ? 'checked' : '' }} />
                        Advertising Received
                    </label>
                    <x-button>Save</x-button>
                </div>

            </x-cards.main>

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
                <div>

                    <h2 class="text-2xl mb-4">Notes</h2>

                    <div>

                        <template x-for="(field, index) in fields" :key="index">
                            <div class="flex gap-3 p-1.5" :class="{ 'border-t border-otgray' : index > 0 , 'bg-otgray-50' : index % 2 > 0 }">
                                <div class=" w-10">
                                    <img :src="field.user_image" class="rounded-full" />
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-400 leading-4">
                                        <span x-text="field.user.name"></span> &bull;
                                        <span x-text="field.created_at_formatted"></span>
                                    </div>
                                    <div class="text-sm" x-text="field.note"></div>
                                </div>
                            </div>
                        </template>

                    </div>

                    <div class="flex gap-3 mt-2">
                        <div class="flex-1">
                            <x-input id="new_note" name="new_note" type="text" placeholder="Add Note" x-model="formData.new_note" @keydown.enter.prevent="submitData" />
                        </div>
                        <div>
                            <button @click.prevent="submitData" x-text="buttonLabel" :disabled="loading" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150">Add Note</button>
                        </div>
                    </div>

                </div>

            </x-cards.main>
        </form>



        <script type="text/javascript">
            function formHandler() {
                    return {
                        
                        attendees: {!! $vendorRegistrationSubmission->attendees !!},
                        deleter: [],
                        
                        addAttendee() {
                            // console.log('adding attendee');
        
                            this.attendees.push({
                                // open:false,
                               
                            });
                        },
                        removeAttendee(index) {
                            id = this.attendees[index].id;
                            if(id) {this.deleter.push(id);}
                            this.attendees.splice(index, 1);
                        },  
        
                        fields: {!! $vendorNotes !!},
                        // fields: [],
                                               
                        formData: {
                            new_note: '',
                            submission_id: '{{ $vendorRegistrationSubmission->id }}',
                            _token: document.head.querySelector('meta[name=csrf-token]').content
                        },
                        
                        loading: false,
                        buttonLabel: 'Add Note',
        
                        submitData() {
                            if (this.formData.new_note != '') {
                                this.buttonLabel = 'Saving';
                                this.loading = true;
                                
                                fetch('{{ route('admin.vendor-registration-submissions.add-note', [$conference, $vendorRegistrationSubmission]) }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify(this.formData)
                                })
                                .then(response => response.json())
                                .then((data) => {
                                    // this.message = 'Form sucessfully submitted!';
                                    console.log(data);
                                    console.log(data.fileName);
                                    this.fields.push(data);
                                    // this.fields.push({
                                    //     details: 'details line',
                                    //     note: this.formData.new_note,
                                    //     image: '<span class="text-red-900">hello</span>'
                                    // });
                                    this.formData.new_note = '';
                                })
                                .catch(() => {
                                    // this.message = 'Ooops! Something went wrong!'
                                })
                                .finally(() => {
                                    this.loading = false;
                                    this.buttonLabel = 'Add Note';
                                });
                            }
                        }
        
        
                    }
                }
        </script>


    </div>



</x-app-layout>