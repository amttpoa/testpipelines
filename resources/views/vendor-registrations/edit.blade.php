<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.vendor-registration-submissions.index', $vendorRegistrationSubmission->conference) }}">Vendors</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.vendor-registration-submissions.show', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}">{{ $vendorRegistrationSubmission->organization->name }}</x-crumbs.a>
            Edit Submission
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
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>


    <form method="POST" id="main-form" action="{{ route('admin.vendor-registration-submissions.update', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission]) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="grid lg:grid-cols-3 gap-6">

            <x-cards.main class="col-span-2">



                <div class="flex gap-4">

                    <x-fields.select label="Sponsorship" name="sponsorship" :selections="$sponsorships" :selected="$vendorRegistrationSubmission->sponsorship" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="sponsorship_price" value="{{ $vendorRegistrationSubmission->sponsorship_price }}" class="mb-4 w-20" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Live Fire" name="live_fire" value="{{ $vendorRegistrationSubmission->live_fire }}" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="live_fire_price" value="{{ $vendorRegistrationSubmission->live_fire_price }}" class="mb-4 w-20" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Lunch" name="lunch" value="{{ $vendorRegistrationSubmission->lunch }}" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="lunch_price" value="{{ $vendorRegistrationSubmission->lunch_price }}" class="mb-4 w-20" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Power" name="power" value="{{ $vendorRegistrationSubmission->power }}" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="power_price" value="{{ $vendorRegistrationSubmission->power_price }}" class="mb-4 w-20" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="TV" name="tv" value="{!! $vendorRegistrationSubmission->tv !!}" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="tv_price" value="{{ $vendorRegistrationSubmission->tv_price }}" class="mb-4 w-20" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Internet" name="internet" value="{!! $vendorRegistrationSubmission->internet !!}" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="internet_price" value="{{ $vendorRegistrationSubmission->internet_price }}" class="mb-4 w-20" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Tables" name="tables" value="{{ $vendorRegistrationSubmission->tables }}" class="mb-4 lg:w-80" />
                    <x-fields.input-text label="Price" name="tables_price" value="{{ $vendorRegistrationSubmission->tables_price }}" class="mb-4 w-20" />
                </div>

                <div class="flex gap-4">
                    <x-fields.input-text label="Total" name="total" value="{{ $vendorRegistrationSubmission->total }}" class="mb-4" />
                    <x-fields.input-text label="Lunch Qty" name="lunch_qty" value="{{ $vendorRegistrationSubmission->lunch_qty }}" class="mb-4" />
                    <x-fields.input-text label="Tables Qty" name="tables_qty" value="{{ $vendorRegistrationSubmission->tables_qty }}" class="mb-4" />
                </div>

                <div class="flex gap-4">
                    <x-fields.input-text label="Advertising Name" name="advertising_name" value="{{ $vendorRegistrationSubmission->advertising_name }}" class="mb-4" />
                    <x-fields.input-text label="Advertising Email" name="advertising_email" value="{{ $vendorRegistrationSubmission->advertising_email }}" class="mb-4 flex-1" />
                    <x-fields.input-text label="Advertising Phone" name="advertising_phone" value="{{ $vendorRegistrationSubmission->advertising_phone }}" class="mb-4" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Live Fire Name" name="live_fire_name" value="{{ $vendorRegistrationSubmission->live_fire_name }}" class="mb-4" />
                    <x-fields.input-text label="Live Fire Email" name="live_fire_email" value="{{ $vendorRegistrationSubmission->live_fire_email }}" class="mb-4 flex-1" />
                    <x-fields.input-text label="Live Fire Phone" name="live_fire_phone" value="{{ $vendorRegistrationSubmission->live_fire_phone }}" class="mb-4" />
                </div>
                <div class="flex gap-4">
                    <x-fields.input-text label="Billing Name" name="billing_name" value="{{ $vendorRegistrationSubmission->billing_name }}" class="mb-4" />
                    <x-fields.input-text label="Billing Email" name="billing_email" value="{{ $vendorRegistrationSubmission->billing_email }}" class="mb-4 flex-1" />
                    <x-fields.input-text label="Billing Phone" name="billing_phone" value="{{ $vendorRegistrationSubmission->billing_phone }}" class="mb-4" />
                </div>

            </x-cards.main>

            <x-cards.main class="" x-data="formHandler()">
                <div class="font-medium text-xl">
                    Representatives
                </div>
                <div>
                    <template x-for="(attendee, index) in attendees" :key="index">
                        <div class="py-2" :class="{ 'border-t border-otgray' : index > 0 }">
                            <div class="flex gap-3 items-center">
                                <div class="mb-3 flex-1">
                                    <x-label for="attendee_name[]">Name</x-label>
                                    <x-input name="attendee_name[]" type="text" x-model="attendee.name" required />
                                </div>
                                <div class="" x-show="index > 0">
                                    <div class="text-otgold font-medium cursor-pointer" @click.prevent="removeAttendee(index);">Remove</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-label for="attendee_email[]">Email</x-label>
                                <x-input name="attendee_email[]" type="text" x-model="attendee.email" />
                            </div>
                            <div class="mb-3">
                                <x-label for="attendee_phone[]">Phone</x-label>
                                <x-input name="attendee_phone[]" type="text" x-model="attendee.phone" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" />
                                <input type="hidden" name="attendee_id[]" x-model="attendee.id" />
                            </div>
                            <div class="mb-3">
                                <x-label for="card_first_name[]">Badge First Name</x-label>
                                <x-input name="card_first_name[]" type="text" x-model="attendee.card_first_name" />
                            </div>
                            <div class="mb-3">
                                <x-label for="card_last_name[]">Badge Last Name</x-label>
                                <x-input name="card_last_name[]" type="text" x-model="attendee.card_last_name" />
                            </div>
                            <div class="mb-3">
                                <x-label for="card_type[]">Badge Type</x-label>
                                <x-input name="card_type[]" type="text" x-model="attendee.card_type" />
                            </div>
                        </div>
                    </template>
                    <div class="">
                        <input type="hidden" x-model="deleter" name="delete" />
                        <x-button type="button" type="light" @click.prevent="addAttendee();">Add Another Representative</x-button>
                    </div>
                </div>



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


            </x-cards.main>
        </div>

    </form>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>



</x-app-layout>