<x-site-layout>

    <div class="h-48 bg-black bg-cover bg-center" style="background-image:url(/img/form-banner.jpg);">
        <div class="h-full" style="background-color: rgba(0,0,0,.7);">
            <div class="h-full flex flex-col justify-center max-w-7xl mx-auto">
                <div class="text-otgold font-blender text-6xl font-bold text-center">
                    Vendor Exhibition Registration
                </div>
            </div>
        </div>
    </div>

    @if(request()->get('registration') == 'complete')
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">
            <div class="font-medium text-2xl lg:text-3xl">
                Thank you for registering for the vendor exhibition
            </div>
            <div class="mt-4">
                We will get back to you soon.
                Some other instuctions and such.
                Maybe some more things, I don't know.
                Just let me know what you what to happen after the form is submitted.
            </div>
        </div>
    </div>
    @else

    <section x-data="formHandler()" class="flex-1 bg-otsteel px-4">

        <form method="POST" id="main-form" action="{{ route('exhibitionRegistrationPost') }}">
            @csrf
            <div class="max-w-5xl h-full mx-auto bg-white shadow">

                <div class="lg:flex lg:gap-6">
                    <div class="flex-1 p-6">

                        <x-form-errors />

                        <div class="prose max-w-full mb-8">
                            <p>
                                Some kind of instuctions for vendor registration go here.
                                Maybe something about how you have to fill out the entire form.
                                <br><br>
                                Vendors that select a <span class="font-semibold">Silver, Gold, Platinum, Corporate, or Premier Corporate</span> sponsorship will be GUARANTEED placement in the main room.
                            </p>
                        </div>


                        <div class="font-semibold text-2xl mb-2">Company Information</div>

                        <x-fields.input-text label="Company/Organization Name" name="company_name" xmodel="company_name" @change="updateTotal" class="mb-4" required />
                        <x-fields.input-text label="Company/Organization Website" name="company_website" xmodel="company_website" @change="updateTotal" class="mb-4" required />



                        <div class="font-semibold text-2xl mt-8">Choose your sponsorship</div>
                        <div class="mb-6">
                            <div class="text-lg">


                                <template x-for="(radio, index) in radios.sponsorship" :key="index">
                                    <label :class="{'bg-otgray-100': sponsorship.price == radio.price}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                        <input type="radio" name="sponsorship" :value="radio.value" @change="chooseRadio('sponsorship', radio)" />
                                        <div class="flex-1">
                                            <div x-html="radio.name"></div>
                                            <div x-html="radio.sub" class="text-xs text-otgray"></div>
                                        </div>
                                        <div class="font-semibold text-xl text-right" x-html="radio.price_display">$700</div>
                                    </label>
                                </template>
                                {{--
                                <label :class="{'bg-otgray-100': sponsorship.price == '700'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Booth with table" data-price="700" data-name="1 (one) 10'x10' booth space w/8' Table" @change="updateTotal" />
                                    <div class="flex-1">1 (one) 10'x10' booth space w/8' Table</div>
                                    <div class="font-semibold text-xl text-right">$700</div>
                                </label>
                                <label :class="{'bg-otgray-100': sponsorship.price == '2000'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Hospitality Night Sponsor" data-price="2000" data-name="Hospitality Night Sponsor" @change="updateTotal" />
                                    <div class="flex-1">
                                        Hospitality Night Sponsor
                                        <div class="text-xs text-otgray">One (1) quarter (1/4) page ad in the Conference Brochure</div>
                                    </div>
                                    <div class="font-semibold text-xl text-right">$2,000</div>
                                </label>
                                <label :class="{'bg-otgray-100': sponsorship.price == '3000'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Silver Sponsor" data-price="3000" data-name="Silver Sponsor" @change="updateTotal" />
                                    <div class="flex-1">
                                        Silver Sponsor - <span class="font-medium uppercase">Main Room</span>
                                        <div class="text-xs text-otgray">One (1) half (1/2) page ad in the Conference Brochure</div>
                                    </div>
                                    <div class="font-semibold text-xl text-right">$3,000</div>
                                </label>
                                <label :class="{'bg-otgray-100': sponsorship.price == '4000'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Gold Sponsor" data-price="4000" data-name="Gold Sponsor" @change="updateTotal" />
                                    <div class="flex-1">
                                        Gold Sponsor - <span class="font-medium uppercase">Main Room</span>
                                        <div class="text-xs text-otgray">One (1) half (1/2) page ad in the Conference Brochure</div>
                                    </div>
                                    <div class="font-semibold text-xl text-right">$4,000</div>
                                </label>
                                <label :class="{'bg-otgray-100': sponsorship.price == '7000'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Platinum Sponsor" data-price="7000" data-name="Platinum Sponsor" @change="updateTotal" />
                                    <div class="flex-1">
                                        Platinum Sponsor - <span class="font-medium uppercase">Main Room</span>
                                        <div class="text-xs text-otgray">One (1) FULL page ad in the Conference Brochure</div>
                                    </div>
                                    <div class="font-semibold text-xl text-right">$7,000</div>
                                </label>
                                <label :class="{'bg-otgray-100': sponsorship.price == '10000'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Corporate Sponsor" data-price="10000" data-name="Corporate Sponsor" @change="updateTotal" />
                                    <div class="flex-1">
                                        Corporate Sponsor - <span class="font-medium uppercase">Main Room</span>
                                        <div class="text-xs text-otgray">One (1) two-page spread ad in the Conference Brochure</div>
                                    </div>
                                    <div class="font-semibold text-xl text-right">$10,000</div>
                                </label>
                                <label :class="{'bg-otgray-100': sponsorship.price == '30000'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="sponsorship" value="Premier Corporate Sponsor" data-price="30000" data-name="Premier Corporate Sponsor" @change="updateTotal" />
                                    <div class="flex-1">
                                        Premier Corporate Sponsor - <span class="font-medium uppercase">Main Room</span>
                                    </div>
                                    <div class="font-semibold text-xl text-right">$30,000</div>
                                </label> --}}
                            </div>
                        </div>


                        <div x-show="sponsorship.price > 700">
                            <div class="font-semibold text-2xl mt-8 mb-2">Advertising Contact Information</div>
                            <x-fields.input-text label="Name" name="advertising_name" class="mb-4" xmodel="advertising_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="advertising_email" class="mb-4" xmodel="advertising_email" @change="updateTotal" />
                            <div class="mb-3">
                                <x-label for="advertising_phone">Phone</x-label>
                                <x-input name="advertising_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="advertising_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div class="font-semibold text-2xl mt-8">Live Fire Event</div>
                        <div class="mb-6">
                            <div class="text-lg">
                                <label :class="{'bg-otgray-100': liveFire.price == '0'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="live_fire" value="No" data-price="0" data-name="" @change="updateTotal" />
                                    <div class="flex-1">I am <span class="font-medium">NOT</span> attending the Live Fire</div>
                                    <div class="font-semibold text-xl text-right"></div>
                                </label>
                                <label :class="{'bg-otgray-100': liveFire.price == '500'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="live_fire" value="Yes" data-price="500" data-name="Live Fire Event" @change="updateTotal" />
                                    <div class="flex-1">I want to participate in the Live Fire Event</div>
                                    <div class="font-semibold text-xl text-right">$500</div>
                                </label>
                            </div>
                        </div>

                        <div x-show="liveFire.price > 0">
                            <div class="font-semibold text-2xl mt-8 mb-2">Live Fire Event Contact Information</div>
                            <x-fields.input-text label="Name" name="live_fire_name" class="mb-4" xmodel="live_fire_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="live_fire_email" class="mb-4" xmodel="live_fire_email" @change="updateTotal" />
                            <div class="mb-4">
                                <x-label for="live_fire_phone">Phone</x-label>
                                <x-input name="live_fire_phone" id="live_fire_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="live_fire_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div>
                            <div class=" font-semibold text-2xl mt-8 mb-2">Primary Company Contact Information
                            </div>
                            <x-fields.input-text label="Name" name="primary_name" class="mb-4" xmodel="primary_name" @change="updateTotal" />
                            <x-fields.input-text label="Email" name="primary_email" class="mb-4" xmodel="primary_email" @change="updateTotal" />
                            <div class="mb-4">
                                <x-label for="primary_phone">Phone</x-label>
                                <x-input name="primary_phone" id="primary_phone" type="text" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" x-model="primary_phone" @change="updateTotal" />
                            </div>
                        </div>


                        <div>
                            <div class="font-semibold text-2xl mt-8">Company Representative(s) Attending</div>

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
                            <select name="lunch" @change="updateTotal" x-model="lunchSelector" class="py-1 pl-2 rounded-md shadow-sm border-otblue-300 focus:border-otblue focus:ring focus:ring-otblue-100 placeholder:text-gray-400">
                                <option value="0">No extra box lunches</option>
                                <template x-for="(attendee, index) in attendees" :key="index">
                                    <option x-show="index > 1" :value="index - 1" x-text="index  > 2 ? (index - 1) + ' extra box lunches' : (index - 1) + ' extra box lunch'">Something</option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <div class="font-semibold text-2xl mt-8 mb-2">Additional Options</div>
                        </div>


                        <x-label>Do you need power?</x-label>
                        <div class="mb-6">
                            <div class="text-lg">
                                <label :class="{'bg-otgray-100': power.price == '0'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="power" value="No" data-price="0" data-name="" @change="updateTotal" />
                                    <div class="flex-1">No, I don't need power</div>
                                    <div class="font-semibold text-xl text-right"></div>
                                </label>
                                <label :class="{'bg-otgray-100': power.price == '40'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="power" value="Standard" data-price="40" data-name="Standard power" @change="updateTotal" />
                                    <div class="flex-1">Yes, I need standard power</div>
                                    <div class="font-semibold text-xl text-right">$40</div>
                                </label>
                                <label :class="{'bg-otgray-100': power.price == '275'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="power" value="3 phase" data-price="275" data-name="3 phase power" @change="updateTotal" />
                                    <div class="flex-1">Yes, I need 125-250 volts - 3 phase 30 amps</div>
                                    <div class="font-semibold text-xl text-right">$275</div>
                                </label>
                            </div>
                        </div>

                        <div x-show="power.price == '40'">
                            <x-label>Do you need a TV?</x-label>
                            <div class="mb-6">
                                <div class="text-lg">
                                    <label :class="{'bg-otgray-100': tv.price == '0'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                        <input type="radio" name="tv" value="No" data-price="0" data-name="" @change="updateTotal" />
                                        <div class="flex-1">No TV needed</div>
                                        <div class="font-semibold text-xl text-right"></div>
                                    </label>
                                    <label :class="{'bg-otgray-100': tv.price == '150'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                        <input type="radio" name="tv" value="32&quot; LCD Flat Screen TV" data-price="150" data-name="32&quot; LCD Flat Screen TV" @change="updateTotal" />
                                        <div class="flex-1">32&quot; LCD Flat Screen TV</div>
                                        <div class="font-semibold text-xl text-right">$150</div>
                                    </label>
                                    <label :class="{'bg-otgray-100': tv.price == '200'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                        <input type="radio" name="tv" value="42&quot; LCD Flat Screen TV" data-price="200" data-name="42&quot; LCD Flat Screen TV" @change="updateTotal" />
                                        <div class="flex-1">42&quot; LCD Flat Screen TV</div>
                                        <div class="font-semibold text-xl text-right">$200</div>
                                    </label>
                                    <label :class="{'bg-otgray-100': tv.price == '250'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                        <input type="radio" name="tv" value="55&quot; LCD Flat Screen TV" data-price="250" data-name="55&quot; LCD Flat Screen TV" @change="updateTotal" />
                                        <div class="flex-1">55&quot; LCD Flat Screen TV</div>
                                        <div class="font-semibold text-xl text-right">$250</div>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <x-label>Do you need high speed internet?</x-label>
                        <div class="mb-6">
                            <div class="text-lg">
                                <label :class="{'bg-otgray-100': internet.price == '0'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="internet" value="No" data-price="0" data-name="" @change="updateTotal" />
                                    <div class="flex-1">No, I will use the Free WiFi</div>
                                    <div class="font-semibold text-xl text-right"></div>
                                </label>
                                <label :class="{'bg-otgray-100': internet.price == '150'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="internet" value="High speed internet" data-price="150" data-name="High speed internet" @change="updateTotal" />
                                    <div class="flex-1">Yes, I need high speed broadband internet</div>
                                    <div class="font-semibold text-xl text-right">$150</div>
                                </label>
                            </div>
                        </div>

                        <x-label>Do you need extra tables?</x-label>
                        <div class="mb-6">
                            <div class="text-lg">
                                <label :class="{'bg-otgray-100': tables.price == '0'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="tables" value="No" data-price="0" data-name="" @change="updateTotal" />
                                    <div class="flex-1">No extra tables needed</div>
                                    <div class="font-semibold text-xl text-right"></div>
                                </label>
                                <label :class="{'bg-otgray-100': tables.price == '60'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="tables" value="One extra table" data-price="60" data-name="One extra table" @change="updateTotal" />
                                    <div class="flex-1">One extra table</div>
                                    <div class="font-semibold text-xl text-right">$60</div>
                                </label>
                                <label :class="{'bg-otgray-100': tables.price == '120'}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                                    <input type="radio" name="tables" value="Two extra tables" data-price="120" data-name="Two extra tables" @change="updateTotal" />
                                    <div class="flex-1">Two extra tables</div>
                                    <div class="font-semibold text-xl text-right">$120</div>
                                </label>
                            </div>
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


                        <div class="font-semibold text-2xl mt-8 mb-2">Agreements</div>

                        <div class="">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="payment_agreement" value="true" x-model="payment_agreement" @change="updateTotal">
                                <i class="fa-regular fa-square text-4xl" x-show="!payment_agreement" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-4xl" x-show="payment_agreement" style="display:none;"></i>
                                <div class="text-lg font-medium leading-tight">
                                    I acknowledge and understand that ALL invoices are REQUIRED to be paid in full before June 1st, 2022.
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
                                    <div x-show="liveFire.name" class="flex gap-4 text-xl py-1.5 border-b border-otgray-300">
                                        <div x-text="liveFire.name" class="flex-1"></div>
                                        <div>$<span x-text="liveFire.price" class="text-right font-medium"></span></div>
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
                                <input type="hidden" name="total" x-model="total">
                                <input type="hidden" name="sponsorship_price" x-model="sponsorship.price">
                                <input type="hidden" name="live_fire_price" x-model="liveFire.price">
                                <input type="hidden" name="lunch_price" x-model="lunch.price">
                                <input type="hidden" name="power_price" x-model="power.price">
                                <input type="hidden" name="tv_price" x-model="tv.price">
                                <input type="hidden" name="internet_price" x-model="internet.price">
                                <input type="hidden" name="tables_price" x-model="tables.price">
                                <button :disabled="!buttonActive" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium">
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

        </form>

        <div x-show="termsModal" style="display:none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="termsModal" class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

                    <div x-show="termsModal" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="prose max-w-full max-h-96 overflow-y-auto p-2 m-4 border border-otgray-300 rounded text-sm">
                            <p>A Terms and Conditions agreement acts as legal contracts between you (the company) who has the website or mobile app, and the user who accesses your website/app.</p>
                            <p>Having a Terms and Conditions agreement is completely optional. No laws require you to have one. Not even the super-strict and wide-reaching General Data Protection Regulation (GDPR).</p>
                            <p>Your Terms and Conditions agreement will be uniquely yours. While some clauses are standard and commonly seen in pretty much every Terms and Conditions agreement, it's up to you to set the rules and guidelines that the user must agree to.</p>
                            <p>You can think of your Terms and Conditions agreement as the legal agreement where you maintain your rights to exclude users from your app in the event that they abuse your app, where you maintain your legal rights against potential app abusers, and so on.</p>
                            <p>Terms and Conditions agreements are also known as Terms of Service or Terms of Use agreements. These terms are interchangeable, practically speaking.</p>
                            <p>A Terms and Conditions agreement acts as legal contracts between you (the company) who has the website or mobile app, and the user who accesses your website/app.</p>
                            <p>Having a Terms and Conditions agreement is completely optional. No laws require you to have one. Not even the super-strict and wide-reaching General Data Protection Regulation (GDPR).</p>
                            <p>Your Terms and Conditions agreement will be uniquely yours. While some clauses are standard and commonly seen in pretty much every Terms and Conditions agreement, it's up to you to set the rules and guidelines that the user must agree to.</p>
                            <p>You can think of your Terms and Conditions agreement as the legal agreement where you maintain your rights to exclude users from your app in the event that they abuse your app, where you maintain your legal rights against potential app abusers, and so on.</p>
                            <p>Terms and Conditions agreements are also known as Terms of Service or Terms of Use agreements. These terms are interchangeable, practically speaking.</p>
                            <p>A Terms and Conditions agreement acts as legal contracts between you (the company) who has the website or mobile app, and the user who accesses your website/app.</p>
                            <p>Having a Terms and Conditions agreement is completely optional. No laws require you to have one. Not even the super-strict and wide-reaching General Data Protection Regulation (GDPR).</p>
                            <p>Your Terms and Conditions agreement will be uniquely yours. While some clauses are standard and commonly seen in pretty much every Terms and Conditions agreement, it's up to you to set the rules and guidelines that the user must agree to.</p>
                            <p>You can think of your Terms and Conditions agreement as the legal agreement where you maintain your rights to exclude users from your app in the event that they abuse your app, where you maintain your legal rights against potential app abusers, and so on.</p>
                            <p>Terms and Conditions agreements are also known as Terms of Service or Terms of Use agreements. These terms are interchangeable, practically speaking.</p>
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

    </section>


    <script type="text/javascript">
        function formHandler() {
            return {
                radios: {!! $radios !!},
                company_name: null,
                company_website: null,

                advertising_name: null,
                advertising_email: null,
                advertising_phone: null,

                live_fire_name: null,
                live_fire_email: null,
                live_fire_phone: null,

                primary_name: null,
                primary_email: null,
                primary_phone: null,

                billing_name: null,
                billing_email: null,
                billing_phone: null,

                termsModal: false,
                buttonActive: false,
                fields: [],
                attendees: [],

                sponsorship: {
                    name: null,
                    price: null
                },
                liveFire: {
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
                init() {
                    this.addAttendee();
                },
                addAttendee() {
                    console.log('adding attendee');

                    this.attendees.push({
                        // open:false,
                       
                    });
                    this.checkFilled();
                },
                removeAttendee(index) {
                    this.attendees.splice(index, 1);
                    this.lunchSelector = null;
                    this.updateTotal();
                },  

                chooseRadio(line, radio) {
                    console.log(line);
                    console.log(radio);
                    if(line == 'sponsorship') {
                        this.sponsorship.name = radio.name;
                        this.sponsorship.price = radio.price; 
                    }
                    // line.name = radio.name;
                    // line.price = radio.price;
                    // this.sponsorship.name = this.;
                    // this.sponsorship.price = document.querySelector('input[name="sponsorship"]:checked').dataset.price;
                    //     this.total = this.total + parseInt(this.sponsorship.price);
                    //     console.log(this.total);
                    this.updateTotal();
                },
                
                updateTotal() {
                    // console.log('updateTotal');

                    // let allAreFilled = true;
                    // document.getElementById("main-form").querySelectorAll("[required]").forEach(function(i) {
                    //     if (!allAreFilled) return;
                    //     if (i.type === "radio") {
                    //         let radioValueCheck = false;
                    //         document.getElementById("main-form").querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
                    //             if (r.checked) radioValueCheck = true;
                    //         });
                    //         allAreFilled = radioValueCheck;
                    //         return;
                    //     }
                    //     if (!i.value) { allAreFilled = false;  return; }
                    // });
                    // if (!allAreFilled) {
                    //     console.log('Fill all the fields');
                    //                     }

                    this.total = 0;
                    // console.log(document.querySelector('input[name="sponsorship"]:checked').dataset.price);
                    // if(document.querySelector('input[name="sponsorship"]:checked')) {
                    //     this.sponsorship.name = document.querySelector('input[name="sponsorship"]:checked').dataset.name;
                    //     this.sponsorship.price = document.querySelector('input[name="sponsorship"]:checked').dataset.price;
                    //     this.total = this.total + parseInt(this.sponsorship.price);
                    //     console.log(this.total);
                    // }
                    this.total = this.total + parseInt(this.sponsorship.price);

                    if(document.querySelector('input[name="live_fire"]:checked')) {
                        this.liveFire.name = document.querySelector('input[name="live_fire"]:checked').dataset.name;
                        this.liveFire.price = document.querySelector('input[name="live_fire"]:checked').dataset.price;
                        this.total = this.total + parseInt(this.liveFire.price);
                    }
                    if(document.querySelector('input[name="power"]:checked')) {
                        this.power.name = document.querySelector('input[name="power"]:checked').dataset.name;
                        this.power.price = document.querySelector('input[name="power"]:checked').dataset.price;
                        this.total = this.total + parseInt(this.power.price);
                    }
                    if(document.querySelector('input[name="tv"]:checked')) {
                        this.tv.name = document.querySelector('input[name="tv"]:checked').dataset.name;
                        this.tv.price = document.querySelector('input[name="tv"]:checked').dataset.price;
                        this.total = this.total + parseInt(this.tv.price);
                    }
                    if(document.querySelector('input[name="internet"]:checked')) {
                        this.internet.name = document.querySelector('input[name="internet"]:checked').dataset.name;
                        this.internet.price = document.querySelector('input[name="internet"]:checked').dataset.price;
                        this.total = this.total + parseInt(this.internet.price);
                    }
                    if(document.querySelector('input[name="tables"]:checked')) {
                        this.tables.name = document.querySelector('input[name="tables"]:checked').dataset.name;
                        this.tables.price = document.querySelector('input[name="tables"]:checked').dataset.price;
                        this.total = this.total + parseInt(this.tables.price);
                    }
                    if(this.lunchSelector > 0) {
                        this.lunch.name = "Lunches";
                        this.lunch.price = this.lunchSelector * 25;
                        this.total = this.total + parseInt(this.lunch.price);
                    } else {
                        this.lunch.name = null;
                        this.lunch.price = null;
                    }

                    if(this.sponsorship.price <= 700) {
                        this.advertising_name = null;
                        this.advertising_email = null;
                        this.advertising_phone = null;
                    };
                    if(this.liveFire.price == 0) {
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

                    this.checkFilled();
                },
                checkFilled() {
                    allFilled = true;
                    // console.log(this.sponsorship.price);
                    if(!this.company_name) {allFilled = false};
                    if(!this.company_website) {allFilled = false};
                    if(!this.sponsorship.price) {allFilled = false};
                    if(this.sponsorship.price > 700) {
                        if(!this.advertising_name) {allFilled = false};
                        if(!this.advertising_email) {allFilled = false};
                        if(!this.advertising_phone) {allFilled = false};
                    };
                    if(!this.liveFire.price) {allFilled = false};
                    if(this.liveFire.price > 0) {
                        if(!this.live_fire_name) {allFilled = false};
                        if(!this.live_fire_email) {allFilled = false};
                        if(!this.live_fire_phone) {allFilled = false};
                    };
                    if(!this.primary_name) {allFilled = false};
                    if(!this.primary_email) {allFilled = false};
                    if(!this.primary_phone) {allFilled = false};
                    this.attendees.forEach((element) => {
                        if(!element.name) {allFilled = false};
                        if(!element.email) {allFilled = false};
                        if(!element.phone) {allFilled = false};
                    });
                    if(!this.power.price) {allFilled = false};
                    if(this.power.price == 40) {
                        if(!this.tv.price) {allFilled = false};
                    }
                    if(!this.internet.price) {allFilled = false};
                    if(!this.tables.price) {allFilled = false};
                    if(!this.billing_name) {allFilled = false};
                    if(!this.billing_email) {allFilled = false};
                    if(!this.billing_phone) {allFilled = false};
                    if(!this.payment_agreement) {allFilled = false};
                    if(!this.terms_agreement) {allFilled = false};
                    // console.log(allFilled);
                    this.buttonActive = allFilled;
                },
            }
        }
    </script>

    @endif


</x-site-layout>