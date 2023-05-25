<x-site-layout>


    <div class="h-48 bg-black bg-cover bg-center" style="background-image:url(/img/otoabanner-35thanniversary-protect-and-serve.jpg);">
        <div class="h-full" style="background-color: rgba(0,0,0,.7);">
            <div class="h-full flex flex-col justify-center max-w-7xl mx-auto">
                <div class="text-otgold font-blender text-6xl font-bold text-center">
                    Subscribe
                </div>
            </div>
        </div>
    </div>

    <style>

    </style>

    <section class="bg-white border-b py-8 flex-1">

        <div class="max-w-3xl mx-auto m-8 px-6">

            <form action="subscribe" method="POST" id="subscribe-form">
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
                <div class="form-group text-center">
                    <x-button id="card-button" data-secret="{{ $intent->client_secret }}" class="text-2xl font-medium px-16">Subscribe</x-button>
                </div>
            </form>








        </div>

    </section>

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
</x-site-layout>