<x-dashboard.layout class="px-0 py-0 sm:px-0 sm:py-0">
    @section("pageTitle")
    Vendor Registration
    @endSection

    <div class="md:grid md:grid-cols-2 h-full">

        <div class="p-4 sm:p-6">

            <x-breadcrumbs.holder>
                Vendor Registration
            </x-breadcrumbs.holder>


            <div x-data="formHandler()" class="">

                <x-form-errors />

                <form method="POST" id="main-form" action="{{ route('dashboard.vendor-registrations.update', $vendorRegistrationSubmission) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @if($vendorRegistrationSubmission->public)
                    <div class="mb-4">
                        Your company is listed on the <a class="text-otgold font-medium" href="{{ route('conference.vendors', $vendorRegistrationSubmission->conference) }}">{{ $vendorRegistrationSubmission->conference->name }} Vendors</a> page.
                        You can update the information that is displayed on this page below.
                    </div>
                    @else
                    <div class="mb-4">
                        Once your information is reviewed and approved, your company will be listed on the <a class="text-otgold font-medium" href="{{ route('conference.vendors', $vendorRegistrationSubmission->conference) }}">{{ $vendorRegistrationSubmission->conference->name }} Companies</a> page.
                        You can update the information that will be displayed on this page below.
                    </div>
                    @endif

                    @if($vendorRegistrationSubmission->live_fire == 'Yes' && $vendorRegistrationSubmission->liveFireSubmission == null)
                    <div class="mb-4">
                        You are registered for Live Fire. Please fill out <x-a href="{{ route('dashboard.vendor-registrations.live-fire', $vendorRegistrationSubmission) }}">this form</x-a>.
                    </div>
                    @endif
                    <div class="hidden">
                        <x-fields.input-text label="Company Name" name="company_name" value="{!! $vendorRegistrationSubmission->company_name !!}" class="mb-4" />

                        <x-fields.input-text label="Link to Website" name="company_website" value="{{ $vendorRegistrationSubmission->company_website }}" class="mb-4" />

                        @if($vendorRegistrationSubmission->image)
                        <div class="mb-4">
                            <img class="h-16" src="{{ Storage::disk('s3')->url('vendor-logos/' . $vendorRegistrationSubmission->image) }}" />
                        </div>
                        @else
                        <div class="mb-4 text-red-600 font-medium">
                            No company logo provided
                        </div>
                        @endif

                        <div class="mb-4 flex-1 md:w-30">
                            <x-label for="image">Change Logo Image</x-label>
                            <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg" />
                        </div>

                        <div class="mb-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                            <div class="flex gap-3 items-end">
                                <div class="flex-1">
                                    <x-label for="website_description">Short Website Description</x-label>
                                </div>
                                <div class="pr-2 text-xs text-otsteel-500"><span x-html="count"></span> of <span x-html="$refs.countme.maxLength"></span> character limit</div>
                            </div>
                            <x-textarea id="website_description" name="website_description" rows="4" maxlength="250" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" placeholder="">{{ $vendorRegistrationSubmission->website_description }}</x-textarea>
                        </div>
                    </div>


                    <div>
                        <div class="font-medium text-xl">Company Representative(s) Attending</div>
                        <div class="text-xs">
                            Name will be used for your badge.
                        </div>
                        <template x-for="(attendee, index) in attendees" :key="index">
                            <div class="py-2" :class="{ 'border-t border-otgray' : index > 0 }">
                                <div class="flex gap-3 items-center">
                                    <div class="mb-3 flex-1">
                                        <x-label for="attendee_name[]">Name</x-label>
                                        <x-input name="attendee_name[]" type="text" x-model="attendee.name" @change="updateTotal" required />
                                    </div>
                                    <div class="" x-show="index > 0">
                                        <div class="text-otgold font-medium cursor-pointer" @click.prevent="removeAttendee(index);">Remove</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-label for="attendee_email[]">Email</x-label>
                                    <x-input name="attendee_email[]" type="text" x-model="attendee.email" @change="updateTotal" />
                                </div>
                                <div class="mb-3">
                                    <x-label for="attendee_phone[]">Cell Phone</x-label>
                                    <x-input name="attendee_phone[]" type="tel" x-model="attendee.phone" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" @change="updateTotal" required />
                                    <input type="hidden" name="attendee_id[]" x-model="attendee.id" />
                                </div>
                            </div>
                        </template>
                        <div class="flex justify-end mb-4">
                            <div class="">
                                <x-button-site type="button" type="light" class="text-sm px-2 py-1" @click.prevent="addAttendee();">Add Another Representative</x-button-site>
                            </div>
                        </div>

                        <div class="text-xs mb-4">
                            If you need to add a lunch please contact
                            <span class="font-medium">Terry Graham</span> at <x-a href="mailto:terry.graham@otoa.org">terry.graham@otoa.org</x-a>.
                        </div>
                        <div class="">
                            <x-button-site class="w-full justify-center text-xl font-medium">Update Registration</x-button-site>
                        </div>

                    </div>
                    <input type="hidden" x-model="deleter" name="delete" />
                </form>

            </div>

        </div>

        <div class="bg-otgray-100 p-4 sm:p-6">
            <div class="font-medium text-2xl mb-4">Registration Overview</div>

            <div class="text-xl font-medium py-2 border-b border-otgray-400 flex gap-3">
                <div class="flex-1">{{ $vendorRegistrationSubmission->sponsorship }}</div>
                <div class="">${{ $vendorRegistrationSubmission->sponsorship_price }}</div>
            </div>

            @if($vendorRegistrationSubmission->advertising_name)
            <div class="py-1 border-b border-otgray-400">
                <div class="text-lg font-medium">Advertising Information</div>
                <div>{{ $vendorRegistrationSubmission->advertising_name }}</div>
                <div>{{ $vendorRegistrationSubmission->advertising_email }}</div>
                <div>{{ $vendorRegistrationSubmission->advertising_phone }}</div>
            </div>
            @endif


            <div class="py-1 border-b border-otgray-400">
                @if($vendorRegistrationSubmission->live_fire == 'Yes')
                <div class="text-lg font-medium flex gap-3">
                    <div class="flex-1">Attending Live Fire</div>
                    <div class="">${{ $vendorRegistrationSubmission->live_fire_price }}</div>
                </div>
                <div>{{ $vendorRegistrationSubmission->live_fire_name }}</div>
                <div>{{ $vendorRegistrationSubmission->live_fire_email }}</div>
                <div>{{ $vendorRegistrationSubmission->live_fire_phone }}</div>
                @else
                <div class="text-lg font-medium">Not Attending Live Fire</div>
                @endif
            </div>
            @if($vendorRegistrationSubmission->lunch)
            <div class="text-lg font-medium py-1 border-b border-otgray-400 flex gap-3">
                <div class="flex-1">{{ $vendorRegistrationSubmission->lunch }} extra lunch{{ $vendorRegistrationSubmission->lunch > 1 ? 'es' : '' }}</div>
                <div class="">${{ $vendorRegistrationSubmission->lunch_price }}</div>
            </div>
            @endif
            <div class="text-lg font-medium py-1 border-b border-otgray-400 flex gap-3">
                <div class="flex-1">{{ $vendorRegistrationSubmission->power }}</div>
                <div class="">${{ $vendorRegistrationSubmission->power_price }}</div>
            </div>
            @if($vendorRegistrationSubmission->tv)
            <div class="text-lg font-medium py-1 border-b border-otgray-400 flex gap-3">
                <div class="flex-1">{{ $vendorRegistrationSubmission->tv }}</div>
                <div class="">${{ $vendorRegistrationSubmission->tv_price }}</div>
            </div>
            @endif
            <div class="text-lg font-medium py-1 border-b border-otgray-400 flex gap-3">
                <div class="flex-1">{{ $vendorRegistrationSubmission->internet }}</div>
                <div class="">${{ $vendorRegistrationSubmission->internet_price }}</div>
            </div>
            <div class="text-lg font-medium py-1 border-b border-otgray-400 flex gap-3">
                <div class="flex-1">{{ $vendorRegistrationSubmission->tables }}</div>
                <div class="">${{ $vendorRegistrationSubmission->tables_price }}</div>
            </div>

            <div class="py-1 ">
                <div class="text-lg font-medium">Billing &amp; Invoice Information</div>
                <div>{{ $vendorRegistrationSubmission->billing_name }}</div>
                <div>{{ $vendorRegistrationSubmission->billing_email }}</div>
                <div>{{ $vendorRegistrationSubmission->billing_phone }}</div>
            </div>

            <div class="mt-4">
                If you need to make any changes that can't be made here please contact
                <span class="font-medium">Terry Graham</span> at <x-a href="mailto:terry.graham@otoa.org">terry.graham@otoa.org</x-a>.
            </div>

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

            }
        }
    </script>




</x-dashboard.layout>