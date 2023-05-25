<x-site-layout>
    @section("pageTitle")
    Vendor Registration
    @endSection

    <x-banner bg="/img/form-banner.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Vendor Registration</div>
    </x-banner>

    @if(request()->get('registration') == 'complete')
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">
            <div class="font-medium text-2xl lg:text-3xl">
                Thank you for registering to be a vendor company at the {{ $conference->name }}.
            </div>
            <div class="mt-4">
                Check your email inbox for important information from us.
                <br><br>
                All vendor registrations are reviewed and approved within 48 hours of completing this online vendor registration.
                Once approved, your company will be showcased on the <x-a href="{{ route('conference.vendors', $conference) }}">Vendor companies registered to exhibit at this conference</x-a> page.
                <br><br>
                Invoices will be sent to the email address you provided. Vendor exhibition space is <strong>NOT GUARANTEED</strong> until payment is received.
                <br><br>
                Please keep an eye on your <x-a href="{{ route('dashboard') }}">dashboard</x-a> for more information.
            </div>
        </div>
    </div>
    @else

    @if(!$conference->vendor_active)
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">
            <div class="font-medium text-2xl lg:text-3xl">
                Vendor Registration Not Available
            </div>
            <div class="mt-4">
                Vendor registration is currently not available for the {{ $conference->name }}.
                It should be available {{ $conference->vendor_start_date->format('F j, Y')}}.
            </div>
        </div>
    </div>
    @else

    @guest
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">

            <div class="font-medium text-xl sm:text-2xl mb-5">Exhibitor registrations are only available to companies that have created a vendor company account.</div>
            <div class="mb-5 text-xl">
                Why have a vendor company account with the OTOA?
            </div>
            <div class="text-left max-w-lg mx-auto">
                <ul class="list-disc ml-8">
                    <li>Required to attend as an exhibitor at any OTOA event.</li>

                    <li>Manage your account, your profile, and your company information.</li>

                    <li>Become eligible for the OTOA preferred vendor program, marketing opportunities, and much more.</li>
                </ul>
            </div>

            <div class="mb-5 hidden">
                Maybe there should be a link to the <x-a href="{{ route('conference.sponsorships', $conference) }}">Confernce Sponsorships</x-a> page.
            </div>
            <div class="text-center mt-10">
                <x-button-link-site href="{{ route('register-vendor') }}" class="text-xl">Create Vendor Company Account</x-button-link-site>
            </div>
            <div class="text-center mt-4">
                <x-a href="{{ route('login') }} ">I already have an account</x-a>
            </div>

        </div>
    </div>
    @endguest

    @auth
    @if(auth()->user()->organization)

    @can('vendor')

    @if(auth()->user()->organization->vendorRegistrationSubmissions->where('conference_id', $conference->id)->first())
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">
            <div class="mt-0 text-2xl">
                Your company, <span class="font-medium">{{ auth()->user()->organization->name }}</span>, is already registered to be a vendor for this conference.
                You have until {{ auth()->user()->organization->vendorRegistrationSubmissions->where('conference_id', $conference->id)->first()->conference->vendor_end_date->format('F j, Y') }} to
                <x-a href="{{ route('dashboard.vendor-registrations.edit', auth()->user()->organization->vendorRegistrationSubmissions->where('conference_id', $conference->id)->first()) }}">view and edit your company vendor registration</x-a> if needed.
            </div>
        </div>
    </div>
    @else
    <div x-data="formHandler()" class="flex-1 bg-otsteel">

        <div class="max-w-5xl h-full mx-auto bg-white shadow">

            <div class="lg:flex lg:gap-6">
                <div class="flex-1 p-6">

                    <x-form-errors />

                    <div class="mb-3 text-xl">
                        You are registering your company,
                        <span class="font-semibold">{{ auth()->user()->organization->name }}</span>,
                        to be a vendor at the
                        <span class="font-semibold">{{ $conference->name }}</span>.
                    </div>

                    <div class="text-lg font-medium mb-3">You must complete the entire form.</div>
                    <div class="mb-3">
                        Vendors that select a <span class="font-semibold">Silver, Gold, Platinum, Corporate, or Premier Corporate</span> sponsorship will be GUARANTEED placement in the main room.
                    </div>
                    <div class="mb-3">
                        Two box lunches for company representatives are included with your sponsorship.
                        You can buy additional box lunches for $25 per representative.
                    </div>
                    <div class="mb-8">
                        An email will be sent to all email addresses you provide in this form with customized instructions for each role.
                    </div>
                    <div class="mb-8 text-center">
                        <x-button-link-site href="{{ route('conference.sponsorships', $conference) }}" @click.prevent="boothModal = true">Booth Options &amp; Sponsorships</x-button-link-site>

                    </div>

                    <form method="POST" id="main-form" action="{{ route('exhibitionRegistrationPost', $conference) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="hidden">
                            <div class="font-semibold text-2xl mb-2">Company Information</div>
                            <x-label for="company_name" id="company_name">Company/Organization Name</x-label>
                            <x-input form="main-form" name="company_name" x-model="company_name" @change="updateTotal" class="mb-4" />

                            <x-label for="company_website" id="company_website">Company/Organization Website</x-label>
                            <x-input form="main-form" name="company_website" x-model="company_website" @change="updateTotal" class="mb-4" />
                        </div>

                        <div class="font-semibold text-2xl mt-8">Chose your booth space or sponsorship</div>
                        <div class="mb-6">
                            <template x-for="(radio, index) in radios.sponsorship" :key="index">
                                <label :class="{'bg-otgray-100': sponsorship.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" x-model="sponsorship_chosen" :value="radio.value" @change="chooseRadio('sponsorship', radio)" />
                                    <div class="flex-1">
                                        <div x-html="radio.name"></div>
                                        <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                    </div>
                                    <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div>
                                    <div x-show="radio.description">
                                        <a href="" class="text-otgold" @click.prevent="showDescription(radio)"><i class="fa-solid fa-circle-info" title="Course Description"></i></a>
                                    </div>
                                </label>
                            </template>
                        </div>


                        <div x-show="sponsorship.price > 700">
                            <div class="font-semibold text-2xl mt-8 mb-3">Advertising Contact Information</div>
                            <div class="mb-3 leading-tight">
                                <span x-html="sponsorship_chosen" class="font-medium"></span> includes:
                                <div x-html="advertising_display" class="text-lg"></div>
                            </div>
                            <div class="mb-3">
                                Who do we contact regarding your ad?
                            </div>
                            <x-fields.input-text label="Name" name="advertising_name" class="mb-4" xmodel="advertising_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="advertising_email" class="mb-4" xmodel="advertising_email" @change="updateTotal" />
                            <div class="mb-3">
                                <x-label for="advertising_phone">Phone</x-label>
                                <x-input name="advertising_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="advertising_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div class="font-semibold text-2xl mt-8">Live Fire Event</div>
                        <div class="mb-6">
                            <template x-for="(radio, index) in radios.live_fire" :key="index">
                                <label :class="{'bg-otgray-100': live_fire.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="live_fire" :value="radio.value" @change="chooseRadio('live_fire', radio)" />
                                    <div class="flex-1">
                                        <div x-html="radio.name"></div>
                                        <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                    </div>
                                    <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div>
                                </label>
                            </template>
                        </div>


                        <div x-show="live_fire.price > 0">
                            <div class="font-semibold text-2xl mt-8 mb-2">Live Fire Event Contact Information</div>
                            <x-fields.input-text label="Name" name="live_fire_name" class="mb-4" xmodel="live_fire_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="live_fire_email" class="mb-4" xmodel="live_fire_email" @change="updateTotal" />
                            <div class="mb-4">
                                <x-label for="live_fire_phone">Phone</x-label>
                                <x-input name="live_fire_phone" id="live_fire_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="live_fire_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div class="hidden">
                            <div class="font-semibold text-2xl mt-8 mb-2">Primary Company Contact Information</div>
                            <x-fields.input-text label="Name" name="primary_name" class="mb-4" xmodel="primary_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="primary_email" class="mb-4" xmodel="primary_email" @change="updateTotal" />
                            <div class="mb-4">
                                <x-label for="primary_phone">Phone</x-label>
                                <x-input name="primary_phone" id="primary_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="primary_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div class="mt-8">
                            <div class="font-semibold text-2xl">Company Representative(s) Attending</div>
                            <div class="">
                                <strong>Attention!!!</strong> Please provide names for <strong>ALL</strong> company representatives attending, including <strong>YOU</strong> if you plan to attend as an exhibitor. Exhibitor name badges are created from this section.
                            </div>
                            <template x-for="(attendee, index) in attendees" :key="index">
                                <div class="py-2" :class="{ 'border-t border-otgray' : index > 0 }">
                                    <div class="flex gap-3 items-center">
                                        <div class="mb-3 flex-1">
                                            <x-label for="attendee_name[]">Name</x-label>
                                            <x-input name="attendee_name[]" type="text" x-model="attendee.name" @change="updateTotal" />
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
                                        <x-label for="attendee_phone[]">Phone</x-label>
                                        <x-input name="attendee_phone[]" type="text" x-model="attendee.phone" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" @change="updateTotal" />
                                    </div>
                                </div>
                            </template>
                            <div>
                                <x-button type="button" @click.prevent="addAttendee();">Add Another Representative</x-button>
                            </div>
                        </div>


                        <div x-show="attendees.length > 2">
                            <div class="font-semibold text-2xl mt-8">Extra Box Lunches</div>
                            <div class="text-xs">
                                Two box lunches are included in your sponsorship.
                                You can purhcase an extra box lunch for each extra attendee for an additional $25 each.
                            </div>
                            <template x-for="(attendee, index) in attendees" :key="index">
                                <label :class="{'bg-otgray-100': lunch.price == (index - 1) * 25}" x-show="index > 0" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" x-model="lunchSelector" name="lunch" :value="index - 1" @change="chooseLunch(index)" />
                                    <div class="flex-1">
                                        <div x-html="index == 1 ? 'No extra box lunches' : (index > 2 ? (index - 1) + ' extra box lunches' : (index - 1) + ' extra box lunch')"></div>
                                    </div>
                                    {{-- <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div> --}}
                                </label>
                            </template>

                        </div>


                        <div class="font-semibold text-2xl mt-8 mb-2">Additional Options</div>

                        <x-label>Do you need power?</x-label>
                        <div class="mb-6">
                            <template x-for="(radio, index) in radios.power" :key="index">
                                <label :class="{'bg-otgray-100': power.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="power" :value="radio.value" @change="chooseRadio('power', radio)" />
                                    <div class="flex-1">
                                        <div x-html="radio.name"></div>
                                        <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                    </div>
                                    <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div>
                                </label>
                            </template>
                        </div>

                        <div class="mb-6" x-show="power.price == '40'">
                            <x-label>Do you need a TV?</x-label>
                            <template x-for="(radio, index) in radios.tv" :key="index">
                                <label :class="{'bg-otgray-100': tv.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="tv" :value="radio.value" @change="chooseRadio('tv', radio)" />
                                    <div class="flex-1">
                                        <div x-html="radio.name"></div>
                                        <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                    </div>
                                    <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div>
                                </label>
                            </template>
                        </div>


                        <div class="mb-6">
                            <x-label>Do you need high speed internet?</x-label>
                            <template x-for="(radio, index) in radios.internet" :key="index">
                                <label :class="{'bg-otgray-100': internet.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="internet" :value="radio.value" @change="chooseRadio('internet', radio)" />
                                    <div class="flex-1">
                                        <div x-html="radio.name"></div>
                                        <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                    </div>
                                    <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div>
                                </label>
                            </template>
                        </div>


                        <div class="mb-6">
                            <x-label>Do you need extra tables?</x-label>
                            <template x-for="(radio, index) in radios.tables" :key="index">
                                <label :class="{'bg-otgray-100': tables.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="tables" :value="radio.value" @change="chooseRadio('tables', radio)" />
                                    <div class="flex-1">
                                        <div x-html="radio.name"></div>
                                        <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                    </div>
                                    <div class="font-semibold text-xl text-right" x-html="radio.price_display"></div>
                                </label>
                            </template>
                        </div>


                        <div>
                            <div class="font-semibold text-2xl mt-8 mb-2">Billing &amp; Invoicing Contact Information</div>
                            <x-fields.input-text label="Name" name="billing_name" class="mb-4" xmodel="billing_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="billing_email" class="mb-4" xmodel="billing_email" @change="updateTotal" />
                            <div class="mb-4">
                                <x-label for="billing_phone">Phone</x-label>
                                <x-input name="billing_phone" id="billing_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="billing_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div class="mb-4">
                            <div class="font-semibold text-2xl mt-8 mb-2">Additional Comments or Special Requests</div>
                            <x-label for="comments">Is there anything else we should know about? <span class="ml-2 text-otgray font-normal">(optional)</span></x-label>
                            <x-textarea name="comments" id="comments" rows="5"></x-textarea>
                        </div>

                        <div class="hidden">
                            <div class="font-semibold text-2xl">For Website</div>
                            <div class="text-xs mb-2">
                                Your company will be listed on the <a class="text-otgold font-medium" href="/conferences/tactical-operations-and-public-safety-conference/vendors">Conference Vendor</a> page.
                                Please include a logo and short description of your company.
                                This is optional, but we will probably fill this in if you don't.
                            </div>
                            <div class="mb-3 flex-1 md:w-30">
                                <x-label for="image">Image</x-label>
                                <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg" />
                            </div>

                            <div class="mt-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                                <div class="flex gap-3 items-end">
                                    <div class="flex-1">
                                        <x-label for="website_description">Short Website Description</x-label>
                                    </div>
                                    <div class="pr-2 text-xs text-otsteel-500"><span x-html="count"></span> of <span x-html="$refs.countme.maxLength"></span> character limit</div>
                                </div>
                                <x-textarea id="website_description" name="website_description" rows="4" maxlength="250" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" placeholder="This is optional..."></x-textarea>
                            </div>
                        </div>


                        <div class="font-semibold text-2xl mt-8 mb-2">Agreements</div>

                        <div class="">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="payment_agreement" value="true" x-model="payment_agreement" @change="updateTotal">
                                <i class="fa-regular fa-square text-4xl" x-show="!payment_agreement" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-4xl" x-show="payment_agreement" style="display:none;"></i>
                                <div class="text-lg font-medium leading-tight">
                                    I acknowledge and understand that ALL invoices are REQUIRED to be paid in full before June 1st, 2023.
                                </div>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="terms_agreement" value="true" x-model="terms_agreement" @change="updateTotal">
                                <i class="fa-regular fa-square text-4xl" x-show="!terms_agreement" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-4xl" x-show="terms_agreement" style="display:none;"></i>
                                <div class="text-lg font-medium leading-tight">
                                    I agree to the <a href="" class="text-otgold" @click.prevent="termsModal = true">terms and conditions</a>.
                                </div>
                            </label>
                        </div>


                        <input type="hidden" name="total" x-model="total">
                        <input type="hidden" name="sponsorship_price" x-model="sponsorship.price">
                        <input type="hidden" name="live_fire_price" x-model="live_fire.price">
                        <input type="hidden" name="lunch_price" x-model="lunch.price">
                        <input type="hidden" name="power_price" x-model="power.price">
                        <input type="hidden" name="tv_price" x-model="tv.price">
                        <input type="hidden" name="internet_price" x-model="internet.price">
                        <input type="hidden" name="tables_price" x-model="tables.price">

                    </form>



                </div>



                <div class="lg:w-96 bg-otgray-200 p-6">
                    <div class="sticky top-20">
                        <div class="text-4xl font-medium text-center">
                            Invoicing Totals
                        </div>
                        <div class="mb-6 text-center">
                            All invoices are emailed
                        </div>

                        <div class="rounded-lg bg-white p-4">
                            <div x-show="!total" class="text-otgray text-center font-light">
                                You have not selected anything. Pick a sponsorship option.
                            </div>
                            <div x-show="total > 0">
                                <div x-show="sponsorship.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300 border-b border-otgray-300">
                                    <div x-text="sponsorship.name" class="flex-1"></div>
                                    <div>$<span x-text="sponsorship.price" class="text-right font-medium"></span></div>
                                </div>
                                <div x-show="live_fire.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                    <div x-text="live_fire.name" class="flex-1"></div>
                                    <div>$<span x-text="live_fire.price" class="text-right font-medium"></span></div>
                                </div>
                                <div x-show="lunch.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                    <div x-text="lunch.name" class="flex-1"></div>
                                    <div>$<span x-text="lunch.price" class="text-right font-medium"></span></div>
                                </div>
                                <div x-show="power.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                    <div x-text="power.name" class="flex-1"></div>
                                    <div>$<span x-text="power.price" class="text-right font-medium"></span></div>
                                </div>
                                <div x-show="tv.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                    <div x-text="tv.name" class="flex-1"></div>
                                    <div>$<span x-text="tv.price" class="text-right font-medium"></span></div>
                                </div>
                                <div x-show="internet.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                    <div x-text="internet.name" class="flex-1"></div>
                                    <div>$<span x-text="internet.price" class="text-right font-medium"></span></div>
                                </div>
                                <div x-show="tables.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                    <div x-text="tables.name" class="flex-1"></div>
                                    <div>$<span x-text="tables.price" class="text-right font-medium"></span></div>
                                </div>

                                <div x-show="total > 0" class="flex gap-4 text-2xl border-t border-black pt-2">
                                    <div class="flex-1 font-medium">Total</div>
                                    <div>$<span x-text="total" class="text-right font-medium"></span></div>
                                </div>
                            </div>
                        </div>


                        <div class="text-center mt-4">
                            <button :disabled="!buttonActive" form="main-form" class="inline-flex items-center px-6 py-2.5 shadow-md bg-otgold border border-otgold text-2xl text-white hover:bg-otgold-500 active:bg-otgold-600 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150'">
                                Process Registration
                            </button>
                            <div class="text-xm text-otgray mt-4 px-10" x-show="!buttonActive">
                                Please complete the entire form to submit your registration.
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>


        <div x-show="termsModal" style="display:none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="termsModal" class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

                    <div x-show="termsModal" @click.away="termsModal=false" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="prose max-w-full max-h-96 overflow-y-auto p-2 m-4 border border-otgray-300 rounded text-sm">
                            {!! $terms->content !!}
                        </div>
                        <div class="px-6 py-3 flex gap-3">
                            <div class="flex-1"></div>
                            <x-button @click.prevent="termsModal = false">
                                Close
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="boothModal" style="display:none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="boothModal" class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

                    <div x-show="boothModal" @click.away="boothModal=false" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="prose max-w-full max-h-96 overflow-y-auto p-2 m-4 border border-otgray-300 rounded text-sm">
                            {!! $sponsorships->content !!}
                        </div>
                        <div class="px-6 py-3 flex gap-3">
                            <div class="flex-1"></div>
                            <x-button @click.prevent="boothModal = false">
                                Close
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div x-show="descriptionModal" style="display:none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="descriptionModal" class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

                    <div x-show="descriptionModal" @click.away="descriptionModal=false" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="max-h-96 overflow-y-auto p-2 m-4 border border-otgray-300 rounded">
                            <div x-html="descriptionDisplay.description" class="prose text-base max-w-full"></div>
                        </div>

                        <div class="px-6 py-3 flex gap-3">
                            <div class="flex-1"></div>
                            <x-button @click.prevent="descriptionModal = false">
                                Close
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>


    <script type="text/javascript">
        function formHandler() {
            return {
                sponsorship_chosen: null,

                radios: {!! $radios !!},
                company_name: null,
                company_website: null,

                advertising_name: null,
                advertising_email: null,
                advertising_phone: null,

                advertising_display: null,

                live_fire_name: null,
                live_fire_email: null,
                live_fire_phone: null,

                primary_name: null,
                primary_email: null,
                primary_phone: null,

                billing_name: null,
                billing_email: null,
                billing_phone: null,

                boothModal: false,
                termsModal: false,
                buttonActive: false,
                fields: [],
                attendees: [],

                sponsorship: {
                    name: null,
                    price: null
                },
                live_fire: {
                    name: null,
                    price: null
                },
                lunchSelector: null,
                lunch: {
                    name: null,
                    price: null
                },
                power: {
                    name: null,
                    price: null
                },
                tv: {
                    name: null,
                    price: null
                },
                internet: {
                    name: null,
                    price: null
                },
                tables: {
                    name: null,
                    price: null
                },
                payment_agreement: false,
                terms_agreement: false,
                total: null,
                
                descriptionModal: false,
                descriptionDisplay: {
                    'description': null,
                },

                init() {
                    this.addAttendee();
                },

                showDescription(radio) {
                    // console.log(course);
                    this.descriptionModal = true;
                    this.descriptionDisplay = radio;
                },

                addAttendee() {
                    // console.log('adding attendee');

                    this.attendees.push({
                        // open:false,
                       
                    });
                    this.checkFilled();
                },
                removeAttendee(index) {
                    this.attendees.splice(index, 1);
                    this.lunchSelector = null;
                    this.lunch.name = null;    
                    this.lunch.price = null;
                    this.updateTotal();
                },  

                chooseRadio(line, radio) {
                    // console.log(line);
                    // console.log(radio);
                    if(line == 'sponsorship') {
                        this.sponsorship.name = radio.invoice_display;
                        this.sponsorship.price = radio.price;
                    }
                    if(line == 'live_fire') {
                        this.live_fire.name = radio.invoice_display;
                        this.live_fire.price = radio.price; 
                    }
                    if(line == 'power') {
                        this.power.name = radio.invoice_display;
                        this.power.price = radio.price; 
                    }
                    if(line == 'tv') {
                        this.tv.name = radio.invoice_display;
                        this.tv.price = radio.price; 
                    }
                    if(line == 'internet') {
                        this.internet.name = radio.invoice_display;
                        this.internet.price = radio.price; 
                    }
                    if(line == 'tables') {
                        this.tables.name = radio.invoice_display;
                        this.tables.price = radio.price; 
                    }
                    this.advertising_display = radio.benefit;
                    this.updateTotal();
                },
                chooseLunch(index) {
                    if(index > 0) {
                        this.lunch.name = "Lunches";
                        this.lunch.price = (index - 1) * 25;
                    } else {
                        this.lunch.name = null;
                        this.lunch.price = null;
                    }
                    this.updateTotal();
                },
                
                updateTotal() {
                   

                    
                    // if(this.lunchSelector > 0) {
                    //     this.lunch.name = "Lunches";
                    //     this.lunch.price = this.lunchSelector * 25;
                    //     this.total = this.total + parseInt(this.lunch.price);
                    // } else {
                    //     this.lunch.name = null;
                    //     this.lunch.price = null;
                    // }

                    if(this.sponsorship.price <= 700) {
                        this.advertising_name = null;
                        this.advertising_email = null;
                        this.advertising_phone = null;
                    };
                    if(this.live_fire.price == 0) {
                        this.live_fire_name = null;
                        this.live_fire_email = null;
                        this.live_fire_phone = null;
                    };
                    if(this.power.price != 40) {
                        // console.log('powernot 40');
                        if (document.querySelector('input[name="tv"]:checked')){
                            document.querySelector('input[name="tv"]:checked').checked = false;
                        }
                        this.tv.name = null;
                        this.tv.price = null;
                    };

                    this.total = 0;
                    this.total = this.total + (parseInt(this.sponsorship.price) || 0);
                    this.total = this.total + (parseInt(this.live_fire.price) || 0);
                    this.total = this.total + (parseInt(this.power.price) || 0);
                    this.total = this.total + (parseInt(this.tv.price) || 0);
                    this.total = this.total + (parseInt(this.internet.price) || 0);
                    this.total = this.total + (parseInt(this.tables.price) || 0);
                    this.total = this.total + (parseInt(this.lunch.price) || 0);

                    this.checkFilled();
                },
                checkFilled() {
                    allFilled = true;
                    console.log(this.live_fire.price);
                    // if(!this.company_name) {allFilled = false};
                    // if(!this.company_website) {allFilled = false};
                    if(!this.sponsorship.price) {allFilled = false};
                    if(this.sponsorship.price > 700) {
                        if(!this.advertising_name) {allFilled = false};
                        if(!this.advertising_email) {allFilled = false};
                        if(!this.advertising_phone) {allFilled = false};
                    };
                    if(this.live_fire.price == null) {allFilled = false};
                    if(this.live_fire.price > 0) {
                        if(!this.live_fire_name) {allFilled = false};
                        if(!this.live_fire_email) {allFilled = false};
                        if(!this.live_fire_phone) {allFilled = false};
                    };
                    // if(!this.primary_name) {allFilled = false};
                    // if(!this.primary_email) {allFilled = false};
                    // if(!this.primary_phone) {allFilled = false};
                    this.attendees.forEach((element) => {
                        if(!element.name) {allFilled = false};
                        if(!element.email) {allFilled = false};
                        if(!element.phone) {allFilled = false};
                    });
                    if(this.power.price == null) {allFilled = false};
                    if(this.power.price == 40) {
                        if(this.tv.price == null) {allFilled = false};
                    }
                    if(this.internet.price == null) {allFilled = false};
                    if(this.tables.price == null) {allFilled = false};
                    if(!this.billing_name) {allFilled = false};
                    if(!this.billing_email) {allFilled = false};
                    if(!this.billing_phone) {allFilled = false};
                    if(!this.payment_agreement) {allFilled = false};
                    if(!this.terms_agreement) {allFilled = false};
                    console.log(allFilled);
                    this.buttonActive = allFilled;
                },
            }
        }
    </script>
    @endif

    @else
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">
            <div class="font-medium text-2xl lg:text-3xl">
                Vendor show registration is only available to users that have created a vendor company user account.
            </div>
            <div class="mt-4">
                If you are a vendor company please contact <x-a href="mailto:office@otoa.org">office@otoa.org</x-a>.
            </div>
        </div>
    </div>
    @endcan

    @endif
    @endauth

    @endif

    @endif

</x-site-layout>