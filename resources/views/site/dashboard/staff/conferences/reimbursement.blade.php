<x-dashboard.layout>
    @section("pageTitle")
    Reimbursement
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.conferences.show', $conference) }}">{{ $conference->name }}</a>
        <x-breadcrumbs.arrow />
        Reimbursement
    </x-breadcrumbs.holder>

    @if(auth()->user()->can('no-reimbursement'))
    <div>No reimburement</div>
    @elseif($reimbursement->status == 'Paid')
    <div>Your reimbursement has been paid.</div>
    @elseif($reimbursement->status == 'Approved')
    <div>Your reimbursement has been approved. Awaiting Payment.</div>
    @else

    <div class="mb-4">
        <x-a class="text-xl" href="{{ route('conference.conference-instructor-information', compact('conference')) }}">Conference Instructor Information</x-a>
    </div>

    <div x-data="formHandler()" x-init="addItem()">
        <form method="POST" id="main-form" action="{{ route('dashboard.staff.conferences.reimbursement', $conference) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="text-2xl font-medium">
                Meals &amp; Gratuities
            </div>
            <div class="mb-4">
                <div class="mb-2">
                    <strong>Note:</strong>
                    ITEMIZED receipts are required for EACH meal. Gratuity not to exceed 20% per meal reimbursement.
                </div>
                <table>
                    <tr>
                        <td class="text-right font-medium pr-2">Breakfast:</td>
                        <td>$10.00 max per day <span class="text-sm">($12.00 w/ tip)</span></td>
                    </tr>
                    <tr>
                        <td class="text-right font-medium pr-2">Lunch:</td>
                        <td>$15.00 max per day <span class="text-sm">($18.00 w/ tip)</span></td>
                    </tr>
                    <tr>
                        <td class="text-right font-medium pr-2">Dinner:</td>
                        <td>$25.00 max per day <span class="text-sm">($30.00 w/ tip)</span></td>
                    </tr>
                </table>

            </div>

            <div class="">

                <div class="lg:flex lg:gap-3 lg:items-end">
                    <div class="lg:w-40 lg:mb-4 font-medium text-xl">Sunday</div>
                    <div class="grid grid-cols-3 gap-3 max-w-md mb-4">
                        <div class="flex flex-col justify-center">
                            <x-label class="lg:text-center">Breakfast</x-label>
                            <div class="bg-red-100 text-xs text-center leading-tight flex-1 flex flex-col items-center justify-center rounded-md">
                                Not provided
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <x-label class="lg:text-center">Lunch</x-label>
                            <div class="bg-red-100 text-xs text-center leading-tight flex-1 flex flex-col items-center justify-center rounded-md">
                                Not provided
                            </div>
                        </div>
                        <div>
                            <x-label class="lg:text-center">Dinner</x-label>
                            <div class="dollar">
                                <x-input @change="updateTotal" x-model="meals[0][2]" type="number" step="0.01" max="30" name="meals[1][3]" value="{{ $reimbursement->reimbursementMeals->where('day', 1)->where('meal', 3)->first() ? number_format($reimbursement->reimbursementMeals->where('day', 1)->where('meal', 3)->first()->price, 2) : '' }}" />
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday'];
                @endphp

                @foreach($days as $key => $day)
                <div class="lg:flex lg:gap-3 lg:items-end">
                    <div class="lg:w-40 lg:mb-4 font-medium text-xl">{{ $day }}</div>
                    <div class="grid grid-cols-3 gap-3 max-w-md mb-4">
                        <div>
                            <x-label class="lg:hidden">Breakfast</x-label>
                            <div class="dollar">
                                <x-input @change="updateTotal" x-model="meals[{{ $key + 1 }}][0]" type="number" step="0.01" max="12" name="meals[{{ $key + 2 }}][1]" value="{{ $reimbursement->reimbursementMeals->where('day', $key + 2)->where('meal', 1)->first() ? number_format($reimbursement->reimbursementMeals->where('day', $key + 2)->where('meal', 1)->first()->price, 2) : '' }}" />
                            </div>
                        </div>
                        <div>
                            <x-label class="lg:hidden">Lunch</x-label>
                            <div class="dollar">
                                <x-input @change="updateTotal" x-model="meals[{{ $key + 1 }}][1]" type="number" step="0.01" max="18" name="meals[{{ $key + 2 }}][2]" value="{{ $reimbursement->reimbursementMeals->where('day', $key + 2)->where('meal', 2)->first() ? number_format($reimbursement->reimbursementMeals->where('day', $key + 2)->where('meal', 2)->first()->price, 2) : '' }}" />
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <x-label class="lg:text-center lg:hidden">Dinner</x-label>
                            <div class="bg-red-100 text-xs text-center leading-tight flex-1 flex flex-col items-center justify-center rounded-md">
                                Provided by<br>OTOA
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


                <div class="lg:flex lg:gap-3 lg:items-end">
                    <div class="lg:w-40 lg:mb-4 font-medium text-xl">Friday</div>
                    <div class="grid grid-cols-3 gap-3 max-w-md mb-4">
                        <div>
                            <x-label class="lg:hidden">Breakfast</x-label>
                            <div class="dollar">
                                <x-input @change="updateTotal" x-model="meals[5][0]" type="number" step="0.01" max="12" name="meals[6][1]" />
                            </div>
                        </div>
                        <div>
                            <x-label class="lg:hidden">Lunch</x-label>
                            <div class="dollar">
                                <x-input @change="updateTotal" x-model="meals[5][1]" type="number" step="0.01" max="18" name="meals[6][2]" />
                            </div>
                        </div>
                        <div>
                            <x-label class="lg:hidden">Dinner</x-label>
                            <div class="dollar">
                                <x-input @change="updateTotal" x-model="meals[5][2]" type="number" step="0.01" max="30" name="meals[6][3]" />
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="text-xl">
                Meals &amp; Gratuities Total:
                <span class="font-medium">$<span x-text="total_meals.toFixed(2)"></span></span>
            </div>


            <div class="text-2xl font-medium mt-8">
                Travel &amp; Lodging
            </div>
            <div class="text-sm mb-2">
                Please enter each item/receipt.
                Click the <strong>Add Additional Item/Receipt</strong> button to add multiple items or receipts.
                Item/Receipt examples include: Gas, Tolls, Airfare, Parking, Cab Fare, Rental Car, Lodging, Etc.
            </div>
            <div class="flex gap-3">
                <div class="w-1/3">
                    <x-label>Item/Receipt</x-label>
                </div>
                <div class="w-40">
                    <x-label>Amount</x-label>
                </div>
                <div class="flex-1">
                    <x-label>Comments</x-label>
                </div>
            </div>
            <template x-for="(item, index) in items" :key="index">
                <div class="flex gap-3 mb-2">
                    <div class="w-1/3">
                        <x-input name="item_name[]" x-model="item.name" />
                    </div>
                    <div class="w-40">
                        <div class="dollar">
                            <x-input @change="updateTotal" name="item_price[]" type="number" x-model="item.price" step='0.01' />
                        </div>
                    </div>
                    <div class="flex-1">
                        <x-input name="item_comments[]" x-model="item.comments" />
                        <x-input name="item_id[]" x-model="item.id" type="hidden" />
                    </div>
                </div>
            </template>
            <div class="mb-4">
                <x-button-site type="light" @click.prevent="addItem();">Add Additional Item/Receipt</x-button-site>
            </div>

            <div class="text-xl">
                Travel &amp; Lodging Total:
                <span class="font-medium">$<span x-text="total_items.toFixed(2)"></span></span>
            </div>
        </form>


        <div class="text-2xl font-medium mt-8">
            Uploads
        </div>
        <div class="mb-4">
            @livewire('reimbursement-uploads', ['reimbursement_id' => $reimbursement->id ])
        </div>



        <div class="text-2xl font-medium mt-8 mb-2">
            Payment Information
        </div>
        <div class="text-xl mb-2">
            Total:
            <span class="font-medium">$<span x-text="total.toFixed(2)"></span></span>
        </div>
        <div class="mb-4 max-w-lg">
            <x-label>Name check should be written to</x-label>
            <x-input form="main-form" name="name" value="{!! $reimbursement->name !!}" required />
        </div>
        <div class="mb-4 max-w-lg">
            <x-label>Address</x-label>
            <x-input form="main-form" name="address" value="{!! $reimbursement->address !!}" required />
        </div>
        <div class="md:flex md:gap-3">
            <div class="mb-4">
                <x-label>City</x-label>
                <x-input form="main-form" name="city" value="{!! $reimbursement->city !!}" required />
            </div>
            <div class="mb-4">
                <x-label>State</x-label>
                <x-input form="main-form" name="state" value="{!! $reimbursement->state !!}" required />
            </div>
            <div class="mb-4">
                <x-label>Zip</x-label>
                <x-input form="main-form" name="zip" value="{!! $reimbursement->zip !!}" required />
            </div>
        </div>
        <div class="mb-4">
            <x-label for="comments">Additional Comments</x-label>
            <x-textarea form="main-form" class="" rows="3" name="comments" class="max-w-xl">{!! $reimbursement->comments !!}</x-textarea>
        </div>

        <div class="text-2xl font-medium mt-8 mb-2">
            Disclosure
        </div>
        <div class="lg:flex lg:gap-6 lg:items-center mb-8">
            <div>
                <label class="block font-medium flex gap-3 item-center">
                    <div>
                        <input form="main-form" type="radio" name="on_duty" value="0" {{ $reimbursement->on_duty === 0 ? 'checked' : ''}} required />
                    </div>
                    <div class="whitespace-nowrap">I was <span class="text-xl">OFF</span> duty</div>
                </label>
                <label class="block font-medium flex gap-3 item-center mt-2">
                    <div>
                        <input form="main-form" type="radio" name="on_duty" value="1" {{ $reimbursement->on_duty === 1 ? 'checked' : ''}} required />
                    </div>
                    <div class="whitespace-nowrap">I was <span class="text-xl">ON</span> duty</div>
                </label>
            </div>
            <div>
                I acknowledge that during the dates and times listed above I did NOT receive reimbursement for expenses from two separate sources. Example - meal expense reimbursement submitted to OTOA and also submitted to agency or company for reimbursement.
            </div>
        </div>

        @if($reimbursement->status == 'Open')
        <div class="mb-8" x-data="{checked:false}">
            <label class="flex items-center gap-3 cursor-pointer">
                <input form="main-form" type="checkbox" class="hidden" name="completed" value="1" x-model="checked">
                <i class="fa-regular fa-square text-4xl" x-show="!checked" style="display:none;"></i>
                <i class="fa-regular fa-square-check text-4xl" x-show="checked" style="display:none;"></i>
                <div class="text-lg font-medium leading-tight">
                    Check here if you are finished
                    <div class="text-xs">
                        If you need to come back later to fill in items or upload reciepts, leave this unchecked
                    </div>
                </div>
            </label>
        </div>
        @endif


        <div class="">
            <x-button-site form="main-form">Submit</x-button-site>
        </div>

    </div>

    <script type="text/javascript">
        function formHandler() {
            return {
                items: {!! $reimbursement->reimbursementItems !!},
                meals: {!! json_encode($meals) !!},
                payer: null,
                total_items: 0,
                total_meals: 0,
                total: 0,
                addItem() {
                    console.log('adding item');
                    this.items.push({
                        
                    });
                    this.updateTotal();
                },
                updateTotal() {
                    console.log('upadating total');
                    this.total_meals = 0;
                    this.meals.forEach((day) => {
                        day.forEach((meal) => {
                            console.log(meal);
                            if (meal) {
                                this.total_meals += parseFloat(meal);
                            }
                        });
                    });
                    this.total_items = 0;
                    this.items.forEach((item) => {
                        if (item.price) {
                            this.total_items += parseFloat(item.price);
                        }
                    });
                    this.total = this.total_meals + this.total_items;
                },
            }
        }
    </script>

    @endif

</x-dashboard.layout>