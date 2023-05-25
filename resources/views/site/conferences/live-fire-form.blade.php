<x-site-layout>
    @section("pageTitle")
    Vendor Registration
    @endSection

    <x-banner bg="/img/form-banner.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Live Fire</div>
    </x-banner>
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-4xl mx-auto bg-white">

            @if(request()->get('form') == 'complete')
            <div class="text-center text-xl">
                Thank you for providing the live fire information.
                Our staff will be in contact very soon.
                Please contact the OTOA Live Team with any questions or concerns at
                <x-a href="mailto:livefire@otoa.org">livefire@otoa.org</x-a>.
            </div>
            @else

            @if($vendorRegistrationSubmission->liveFireSubmission)
            <div class="text-center text-xl mb-8">
                You have already provided the neccessary information.
                Our staff will be in contact very soon.
                Please contact the OTOA Live Team with any questions or concerns at
                <x-a href="mailto:livefire@otoa.org">livefire@otoa.org</x-a>.
            </div>
            <div class="mb-4">
                <div class="font-medium">What are you bringing to the live fire demo?</div>
                <div>{{ $vendorRegistrationSubmission->liveFireSubmission->bringing }}</div>
            </div>
            @if($vendorRegistrationSubmission->liveFireSubmission->firearm)
            <div class="mb-4">
                <div class="font-medium">What type of firearm?</div>
                <div>{{ $vendorRegistrationSubmission->liveFireSubmission->firearm }}</div>
            </div>
            @endif
            @if($vendorRegistrationSubmission->liveFireSubmission->caliber)
            <div class="mb-4">
                <div class="font-medium">What caliber are your weapons?</div>
                <div>{{ $vendorRegistrationSubmission->liveFireSubmission->caliber }}</div>
            </div>
            @endif
            <div class="mb-4">
                <div class="font-medium">Are you sharing a lane on the firearms range with another company?</div>
                <div>{{ $vendorRegistrationSubmission->liveFireSubmission->share }}</div>
            </div>
            @if($vendorRegistrationSubmission->liveFireSubmission->share_with)
            <div class="mb-4">
                <div class="font-medium">Provide the company name and company rep you coordinated with to share a lane on the firearms range</div>
                <div>{{ $vendorRegistrationSubmission->liveFireSubmission->share_with }}</div>
            </div>
            @endif
            <div class="mb-4">
                <div class="font-medium">Describe in detail what you are bringing to demonstrate</div>
                <div>{{ $vendorRegistrationSubmission->liveFireSubmission->description }}</div>
            </div>


            @else

            <div x-data="formHandler()" class="">

                <x-form-errors />

                <form method="POST" id="main-form" action="{{ route('liveFireFormPost', $vendorRegistrationSubmission) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="text-xl mb-10">
                        We need to know what you're bringing.
                    </div>

                    <div class="text-lg font-medium">What are you bringing to the live fire demo?</div>
                    <div class="columns-2 sm:columns-4 gap-3 mb-5">
                        <div>
                            @foreach($bringings as $item)
                            <label class="flex gap-2 px-1 py-0.5">
                                <input value="{{ $item }}" class="mt-0.5" type="checkbox" name="bringing[]" x-model="bringing" />
                                {{ $item }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="bringing.includes('Firearm')">
                        <div class="text-lg font-medium">What type of firearm?</div>
                        <div class="columns-2 sm:columns-4 gap-3 mb-5">
                            <div>
                                @foreach($firearms as $item)
                                <label class="flex gap-2 px-1 py-0.5">
                                    <input value="{{ $item }}" class="mt-0.5" type="checkbox" name="firearm[]" x-model="firearm" />
                                    {{ $item }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-lg font-medium">What caliber are your weapons?</div>
                        <div class="columns-2 sm:columns-4 gap-3 mb-5">
                            <div>
                                @foreach($calibers as $item)
                                <label class="flex gap-2 px-1 py-0.5">
                                    <input value="{{ $item }}" class="mt-0.5" type="checkbox" name="caliber[]" x-model="caliber" />
                                    {{ $item }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="text-lg font-medium">Are you sharing a lane on the firearms range with another company?</div>
                    <div class="flex gap-5 mb-5">
                        <div>
                            <label class="flex gap-2 items-center px-1 py-0.5">
                                <input value="Yes" type="radio" name="share" x-model="share" /> Yes
                            </label>
                        </div>
                        <div>
                            <label class="flex gap-2 items-center px-1 py-0.5">
                                <input value="No" type="radio" name="share" x-model="share" /> No
                            </label>
                        </div>
                    </div>

                    <div x-show="share=='Yes'">
                        <x-fields.input-text label="Provide the company name and company rep you coordinated with to share a lane on the firearms range" name="share_with" class="mb-5" />
                    </div>

                    <x-label for="description">Describe in detail what you are bringing to demonstrate</x-label>
                    <x-textarea class="mb-5" name="description" rows="4"></x-textarea>


                    <div class="mb-5">
                        <label class="flex  gap-3 cursor-pointer">
                            <input type="checkbox" class="hidden" name="agreements" value="true" x-model="agreements" @change="updateTotal">
                            <i class="fa-regular fa-square text-4xl" x-show="!agreements" style="display:none;"></i>
                            <i class="fa-regular fa-square-check text-4xl" x-show="agreements" style="display:none;"></i>
                            <div>
                                <div class="text-xl font-medium leading-tight mt-1.5">
                                    I agree to the following conditions
                                </div>
                                <ul class="list-disc ml-5 text-sm mt-2">
                                    <li>No ammunition of any kind is provided - ALL companies must supply their own</li>
                                    <li>Corbon, green tip, armor piercing ammo is <strong>PROHIBITED</strong></li>
                                    <li>All less lethal and chemical agent munitions <strong>MUST BE INERT</strong></li>
                                    <li>Fully automatic firearms are <strong>PROHIBITED</strong> and I will NOT bring fully automatic firearms</li>
                                    <li>ALL firearms I bring to the demo will be zeroed/sighted-in before the live fire event</li>
                                    <li>There are <strong>NO</strong> body armor or ballistic plate demos/shoots at this live fire event</li>
                                </ul>
                            </div>
                        </label>
                    </div>

                    <div class="">
                        <x-button-site class=" text-xl font-medium">Submit</x-button-site>
                    </div>
                </form>

            </div>

            <script type="text/javascript">
                function formHandler() {
                    return {
                        
                        bringing: [],
                        firearm: [],
                        caliber: [],
                        share: null,
                        attendees: {!! $vendorRegistrationSubmission->attendees !!},
                        deleter: [],
                        agreements: false,
                        
                        addAttendee() {
                            // console.log('adding attendee');
        
                            this.attendees.push({
                                // open:false,
                               
                            });
                        },
        
                    }
                }
            </script>

            @endif
            @endif

        </div>
    </div>

</x-site-layout>