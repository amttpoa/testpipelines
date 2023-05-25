<x-dashboard.layout>
    @section("pageTitle")
    Subscription
    @endSection

    <x-breadcrumbs.holder>
        Subscription
    </x-breadcrumbs.holder>

    <div x-data="formHandler()">

        <form action="{{ route('dashboard.subscribePost') }}" method="POST" id="subscribe-form">
            <div class="form-group mb-4">
                <div class="row">
                    @foreach(array_reverse($plans) as $plan)
                    <div class="col-md-4">
                        <div class="subscription-option">
                            <label class="flex gap-3 mb-3 items-center">
                                <div class="">
                                    <input type="radio" id="plan-silver" name="plan" value='{{$plan->id}}'>
                                </div>
                                <div class="font-bold text-2xl w-24 text-right">
                                    ${{$plan->amount/100}}<span class="font-bold text-sm">/{{$plan->interval}}</span>
                                </div>
                                <div class="text-2xl">
                                    {{$plan->product->name}}
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            {{-- <label for="amount">Card Holder Name</label>
            <input id="amount" name="amount" type="number"> --}}

            <div class="mb-4 max-w-sm">
                <x-label for="card-holder-name">Card Holder Name</x-label>
                <x-input id="card-holder-name" type="text" />
            </div>
            @csrf

            <div class="form-group text-center">
                <x-button id="card-button" data-secret="{{ $intent->client_secret }}" class="text-2xl font-medium px-16">Subscribe</x-button>
            </div>

            <div class="hidden rounded-lg bg-white p-4">

                <div x-show="courses_chosen.length == 0" class="text-otgray text-center font-light">
                    You have not selected anything. Pick select some courses.
                </div>
                <div x-show="courses_chosen.length > 0">
                    <template x-for="course in courses_chosen">
                        <div>
                            <div x-html="course.name"></div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="total == 0" class="text-center mb-4">
                <div class="text-xl text-otgray">You must first select some courses.</div>
            </div>

            <div x-show="total > 0" class="text-center mb-4">
                <div class="font-semibold text-3xl">$<span x-html="total"></span></div>
                <div class="font-medium" x-html="package"></div>
            </div>


            <div>
                <div class="border border-otgray rounded-md overflow-hidden bg-white">
                    <label class="flex px-4 py-2 gap-4 bg-otgray-300 items-center">
                        <input type="radio" name="pay_type" x-model="pay_type" value="invoice" @change="checkComplete" />
                        <div class="flex-1">
                            <div class="font-bold text-xl">Invoice Me</div>
                            <div class="">We will send an invoice to you or your organziation for payment by check</div>
                        </div>
                    </label>
                    <div x-show="pay_type == 'invoice'" class="p-4">
                        <div class="mb-4">
                            Some instructions for getting an invoice.
                        </div>
                        <div class="mb-4">
                            <x-label for="email">Email</x-label>
                            <x-input id="email" name="email" x-model="email">Email to send invoice to</x-input>
                        </div>
                        <x-fields.input-text label="Purchase Order (optional)" name="purchase_order" />
                    </div>
                </div>

                <div class="mt-4 border border-otgray rounded-md overflow-hidden bg-white">
                    <label class="flex px-4 py-2 gap-4 bg-otgray-300 items-center">
                        <input type="radio" name="pay_type" x-model="pay_type" value="credit_card" @change="checkComplete" />
                        <div class="flex-1">
                            <div class="font-bold text-xl">Pay by Credit Card</div>
                            <div class="">Pay now with a Credit Card</div>
                        </div>
                    </label>
                    <div x-show="pay_type == 'credit_card'" class="p-4">

                        <section class="">

                            <div class="">


                                {{-- <label for="amount">Card Holder Name</label>
                                <input id="amount" name="amount" type="number"> --}}

                                <div class="mb-4 max-w-sm">
                                    <x-label for="card-holder-name">Card Holder Name</x-label>
                                    <x-input id="card-holder-name" type="text" />
                                </div>
                                @csrf
                                <div class="mb-4 form-row">
                                    <x-label for="card-element">Credit or debit card</x-label>
                                    <div id="card-element" class="form-control">
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                </div>
                                <div class="stripe-errors"></div>
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                    @endforeach
                                </div>
                                @endif

                            </div>

                        </section>




                    </div>
                </div>


            </div>



            <div class="text-center mt-4">

                <input type="hidden" name="total" x-model="total">
                <input type="hidden" name="package" x-model="package">
                <button @click.prevent="submitData" id="card-button" :disabled="!buttonActive" data-secret="{{ $intent->client_secret }}" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium">
                    Process Registration
                </button>

                <div class="text-xm text-otgray mt-4 px-10" x-show="!buttonActive">
                    Please complete the entire form to submit your registration.
                </div>
            </div>





        </form>

    </div>

    <script type="text/javascript">
        function formHandler() {
            return {
                pay: '',
                pay_type: null,
                email: '{{ auth()->user()->email }}',
                
                courses_chosen: [],
                course_ids: [],

                daysSelected: 0,
                daysSelectedArray: [],
                total: 0,
                package: null,

                company_name: null,
                company_website: null,

                termsModal: false,
                courseModal: false,
                errorModal: false,
                errorMessage: null,

                buttonActive: false,
                courseDisplay: {
                    'description': null,
                    'user_id': null,
                    'profile': null
                },
                init() {
                    // this.checkComplete();
                },
                showCourse(course) {
                    console.log(course);
                    this.courseModal = true;
                    this.courseDisplay = course;
                },

                checkComplete() {
                    this.buttonActive = true;
                    // console.log(Object.keys(this.course_ids).length);
                    if (!Object.keys(this.course_ids).length) {
                        this.buttonActive = false;
                    }
                    if (this.pay_type == null) {
                        this.buttonActive = false;
                    }
                    this.checkDaysSelected();
                },

                

                formData: {
                    course_ids: [],
                    _token: document.head.querySelector('meta[name=csrf-token]').content
                },
                submitData() {
                    
                    console.log('submitData');

                    

                    // window.dispatchEvent(new Event('processRegistration'));
                },

                
            }
        }
    </script>



    @section("scripts")

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
            var elements = stripe.elements();
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            var card = elements.create('card', {hidePostalCode: true,
                style: style});
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            cardButton.addEventListener('click', async (e) => {
                console.log("attempting");
                // alert("here");
                e.preventDefault();
                // alert("here2");
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                    );
                // alert("here3");
                if (error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    paymentMethodHandler(setupIntent.payment_method);
                }
            });
            function paymentMethodHandler(payment_method) {
                var form = document.getElementById('subscribe-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
                form.appendChild(hiddenInput);
                form.submit();
            }
    </script>

    @endsection

</x-dashboard.layout>