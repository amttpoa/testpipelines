<x-dashboard.layout>
    @section("pageTitle")
    Subscription
    @endSection

    <x-breadcrumbs.holder>
        Subscription
    </x-breadcrumbs.holder>

    <div x-data="formHandler()">

        <x-form-errors />

        <form action="{{ route('dashboard.subscribePost') }}" method="POST" id="subscribe-form">
            <div class="text-2xl mb-2">
                Select your membership type
            </div>

            <div class="mb-8 max-w-2xl">
                <template x-for="(oneplan, index) in plans" :key="index">
                    <label :class="{'bg-otgray-100': oneplan.id == plan}" class="mt-2 flex gap-3 items-center p-3 border border-otblue-300 rounded-md">
                        <input type="radio" name="plan" x-model="plan" :value="oneplan.id" @change="checkComplete" />
                        <div class="flex-1">
                            <div x-html="oneplan.name"></div>
                            <div x-html="oneplan.description" class="text-xs text-otgray"></div>
                        </div>
                        <div class="font-bold text-2xl w-24 text-right">
                            $<span x-html="oneplan.price"></span><span class="font-bold text-sm">/year</span>
                        </div>
                    </label>
                </template>
            </div>


            <div class="text-2xl mb-2">
                Payment information
            </div>
            <div class="max-w-2xl">

                <div class="mb-4 max-w-sm">
                    <x-label for="card-holder-name">Card holder name</x-label>
                    <x-input id="card-holder-name" name="name" type="text" />
                </div>
                @csrf
                <div class="md:flex md:gap-3">
                    <div class="mb-4 md:w-60 max-w-sm">
                        <x-label for="cc">Credit card number</x-label>
                        <x-input x-model="cc" x-data="{}" x-mask="9999 9999 9999 9999" placeholder="XXXX XXXX XXXX XXXX" type="text" pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" id="cc" name="cc" required @change="checkComplete" />
                    </div>
                    <div class="mb-4 flex gap-3">
                        <div class="w-14">
                            <x-label>Month</x-label>
                            <x-input x-model="month" name="month" type="text" x-mask="99" placeholder="XX" required @change="checkComplete" />
                        </div>
                        <div class="w-24">
                            <x-label>Year</x-label>
                            <x-input x-model="year" name="year" type="text" x-mask="9999" placeholder="XXXX" required @change="checkComplete" />
                        </div>
                    </div>
                </div>

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="max-w-2xl  mt-4">
                <button id="card-button" :disabled="!buttonActive" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium">
                    Subscribe
                </button>
            </div>

        </form>

    </div>

    <script type="text/javascript">
        function formHandler() {
            return {
                plan: null,
                cc: '',
                month: '',
                year: '',
                pay: '',
                pay_type: null,
                // email: '{{ auth()->user()->email }}',
                email: '',
                code: '',
                buttonActive: false,
                plans: {!! $plans !!},
                init() {
                    // this.checkComplete();
                },
                checkComplete() {
                    console.log(this.cc);
                    this.buttonActive = true;
                    if (this.plan == null || this.cc == '' || this.month == '' || this.year == '') {
                        this.buttonActive = false;
                    }
                    // if (this.pay_type == null) {
                    //     this.buttonActive = false;
                    // }
                },
                submitData() {
                    console.log('submitData');
                },
            }
        }
    </script>



</x-dashboard.layout>