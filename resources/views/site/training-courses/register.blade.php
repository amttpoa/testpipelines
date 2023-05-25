<x-site-layout>
    @section("pageTitle")
    {{ $trainingCourse->training->name }} Register
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('trainings') }}">Advanced Training</a></div>
        <div class="text-3xl lg:text-6xl"><a href="{{ route('training', $trainingCourse->training) }}">{{ $trainingCourse->training->name }}</a></div>
    </x-banner>

    @if(now() >= $trainingCourse->start_date)
    <div class="bg-otsteel flex-1 flex flex-col">
        <div class="max-w-4xl p-6 sm:px-10 flex-1 w-full bg-white mx-auto font-medium text-center text-2xl">
            This course is complete.
        </div>
    </div>

    @elseif(!$trainingCourse->visible)
    <div class="bg-otsteel flex-1 flex flex-col">
        <div class="max-w-4xl p-6 sm:px-10 flex-1 w-full bg-white mx-auto font-medium text-center text-2xl">
            This course is not available.
        </div>
    </div>

    @elseif(!$trainingCourse->active && !($trainingCourse->active_admin && auth()->user()->can('organization-admin')))
    <div class="bg-otsteel flex-1 flex flex-col">
        <div class="max-w-4xl p-6 sm:px-10 flex-1 w-full bg-white mx-auto font-medium text-center text-2xl">
            This course is closed. We are not accepting registrations or waitlist.
        </div>
    </div>

    @else

    <div class="bg-otsteel py-8 flex-1">

        <div class="max-w-3xl mx-auto bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-6 p-2 text-2xl lg:text-4xl font-bold font-blender">
                {{ $trainingCourse->training->name }} Registration
            </div>

            <div class="p-6">
                <div class="float-right text-center ml-4 mb-4">
                    <div class="font-medium text-sm">Price</div>
                    <div class="text-5xl font-blender font-bold">${{ $trainingCourse->price }}</div>
                    <div class="text-otsteel mt-4">{{ $trainingCourse->attendees->count() }} of {{ $trainingCourse->capacity }} seats taken</div>
                </div>
                <div class="">

                    <div class="font-semibold text-3xl">
                        <a href="{{ route('trainingCourse', [$trainingCourse->training->slug, $trainingCourse]) }}">
                            {{ $trainingCourse->training->name }}
                        </a>
                    </div>
                    <div class="font-semibold text-xl">
                        {{ date('F j, Y', strtotime($trainingCourse->start_date)) }}
                        - {{ date('F j, Y', strtotime($trainingCourse->end_date)) }}
                    </div>
                    @if($trainingCourse->venue)
                    <div class="mt-4">
                        <x-a href="{{ route('venue', $trainingCourse->venue->slug) }}" class="text-xl">{{ $trainingCourse->venue->name }}</x-a>
                    </div>
                    <div>
                        @auth
                        {{ $trainingCourse->venue->address }}<br>
                        @endauth
                        {{ $trainingCourse->venue->city }}, {{ $trainingCourse->venue->state }} {{ $trainingCourse->venue->zip }}
                    </div>
                    @endif
                    @if($trainingCourse->description)
                    <div class="prose max-w-full mt-4">
                        {!! $trainingCourse->description !!}
                    </div>
                    @endif
                </div>
            </div>



            <div class="p-6 pt-0">

                @guest
                <div class="text-xl">
                    <x-a href="{{ route('login') }}">Login</x-a> or <x-a href="{{ route('register-choice') }}">Sign Up</x-a>
                    @if($trainingCourse->attendees->count() >= $trainingCourse->capacity)
                    to get on the waitlist for this {{ $trainingCourse->training->name }} course
                    @else
                    to register for this {{ $trainingCourse->training->name }} course
                    @endif
                </div>
                @endguest

                @auth

                @if(auth()->user()->trainingCourseAttendees->where('training_course_id', $trainingCourse->id)->first() && !auth()->user()->can('organization-admin'))
                <x-callouts.info>You are already registered for this course.</x-callouts.info>

                @elseif ($trainingCourse->attendees->count() >= $trainingCourse->capacity)

                @if(auth()->user()->trainingWaitlists->where('training_course_id', $trainingCourse->id)->first())
                <x-callouts.info>You are on the waitlist for this course.</x-callouts.info>
                @else
                <div class="text-xl font-medium">This course is full. Would you like to join the waitlist?</div>
                <form method="POST" x-data="{checked:false}" action="{{ route('trainingCourse.waitlistPost',  [$trainingCourse->training, $trainingCourse]) }}">
                    @csrf
                    <div class="my-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="hidden" name="terms_agreement" value="true" x-model="checked">
                            <i class="fa-regular fa-square text-4xl" x-show="!checked" style="display:none;"></i>
                            <i class="fa-regular fa-square-check text-4xl" x-show="checked" style="display:none;"></i>
                            <div class="text-lg font-medium leading-tight">
                                I want to join the waitlist
                            </div>
                        </label>
                    </div>
                    <x-label for="comments">Comments</x-label>
                    <x-input name="comments" maxlength="250" />
                    <button :disabled="!checked" class="mt-4 w-full px-4 py-1.5 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium px-16">Join Waitlist</button>

                </form>
                @endif

                @else

                <div class="" x-data="payHandler()">
                    @can('organization-admin')
                    <div class="mb-4">
                        You are an <span class="font-medium">Organization Admin</span> for <span class="font-medium">{{ auth()->user()->organization->name }}</span>.
                        Please select the members of your organization that you would like to enroll in this course.
                    </div>
                    <div class="mb-4">
                        Individual you are looking for <span class="font-medium">NOT</span> listed? <x-a href="{{ route('dashboard.organization.user-create', ['redirect' => 'training']) }}">Create a user account here.</x-a>
                    </div>
                    @if($users->count() > ($trainingCourse->capacity - $trainingCourse->attendees->count()))
                    <div class="mb-4 text-xl font-medium text-red-700">
                        There are only <span x-text="available"></span> seats available
                    </div>
                    @endif
                    <div class="mb-4">
                        @include('site.dashboard.organization.organization-chooser')
                    </div>

                    @else
                    <div class="mb-4">
                        <div class="text-xl">
                            You are registering yourself, <span class="font-medium">{{ auth()->user()->name }}</span>, for this course.
                        </div>
                        <div class="text-sm">
                            Need to register someone else? Contact <x-a href="mailto:office@otoa.org" target="_blank">office@otoa.org</x-a> to become an organization admin.
                        </div>
                    </div>
                    @endcan

                    <form method="POST" id="subscribe-form" action="{{ route('trainingCourse.registerPost',  [$trainingCourse->training->slug, $trainingCourse]) }}">
                        @csrf

                        @can('organization-admin')
                        <div class="md:columns-2 md:gap-2 my-6">
                            <template x-for="(user, index) in users" :key="index">
                                <div class="break-inside-avoid border border-otgray rounded-md mb-2" :class="user.registered ? 'bg-otgray-100' : ''">
                                    <label class="flex gap-2 items-center px-3 py-1">
                                        <input type="checkbox" name="user_id[]" x-model="user_id" :value="user.id" @change="checkComplete" class="disabled:bg-otgray-200" :disabled="user.registered" />

                                        <img :src="user.image" class="h-10 w-10 rounded-full" />
                                        <div class="flex-1 overflow-hidden">
                                            <div class="font-medium" x-text="user.name"></div>
                                            <div class="text-sm text-otgray text-ellipsis overflow-hidden" x-text="user.email"></div>
                                        </div>
                                        <div>

                                            <div class="text-xs font-medium" x-show="user.admin">
                                                Admin
                                            </div>
                                            <div class="text-xs font-medium" x-show="user.member">
                                                Member
                                            </div>
                                            <div class="text-xs text-otgray" x-show="user.registered">
                                                Registered
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </template>
                        </div>

                        <div class="mb-4 ">
                            <table>
                                <tr>
                                    <td class="px-2">Registrations:</td>
                                    <td class="px-2 text-right w-24">$<span x-text="total_reg"></span></td>
                                </tr>
                                <tr>
                                    <td class="px-2">Memberships:</td>
                                    <td class="px-2 text-right w-24">$<span x-text="total_sub"></span></td>
                                </tr>
                                <tr class="text-2xl font-medium border-t border-otgray">
                                    <td class="px-2">Total:</td>
                                    <td class="px-2 text-right w-24">$<span x-text="total"></span></td>
                                </tr>
                            </table>
                        </div>
                        @endcan


                        <div class="mb-4">
                            <div class="border border-otgray rounded-md overflow-hidden">
                                <label class="flex px-4 py-2 gap-4 bg-otgray-200 items-center">
                                    <input type="radio" name="pay_type" x-model="pay_type" value="invoice" @change="checkComplete" />
                                    <div class="flex-1">
                                        <div class="font-bold text-xl">Invoice Me</div>
                                        <div class="">Invoices can be paid by check or credit card</div>
                                    </div>
                                </label>
                                <div x-show="pay_type == 'invoice'" class="p-4">
                                    <div class="mb-4">
                                        <strong>IMPORTANT</strong> - List the person that <span class="font-medium">RECEIVES INVOICES FOR PAYMENT</span>.
                                        {{-- Name the individual responsible to process the payment for this class.
                                        All invoices are emailed to the person identified below.
                                        Payment is required before the 1st day of class. --}}
                                    </div>
                                    <div class="mb-4">
                                        <x-label for="name">Name</x-label>
                                        <x-input id="name" name="name" x-model="name" @change="checkComplete" />
                                    </div>
                                    <div class="mb-4">
                                        <x-label for="email">Email</x-label>
                                        <x-input id="email" name="email" x-model="email" @change="checkComplete" />
                                    </div>
                                    {{--
                                    <x-fields.input-text label="Purchase Order (optional)" name="purchase_order" /> --}}
                                </div>
                            </div>

                            <div class="mt-4 border border-otgray rounded-md overflow-hidden {{ (!auth()->user()->subscribed() || auth()->user()->can('organization-admin')) ? 'opacity-50' : '' }}">
                                <label class="flex px-4 py-2 gap-4 bg-otgray-200 items-center">
                                    <input type="radio" name="pay_type" x-model="pay_type" value="credit_card" @change="checkComplete" {{ (!auth()->user()->subscribed() || auth()->user()->can('organization-admin')) ? 'disabled' : '' }} />
                                    <div class="flex-1">
                                        <div class="font-bold text-xl">Pay by Credit Card</div>
                                        <div class="">Pay now with a Credit Card</div>
                                    </div>
                                </label>
                                <div x-show="pay_type == 'credit_card'" class="p-4">
                                    <div class="mb-4 max-w-sm">
                                        <x-label for="card_holder_name">Card holder name</x-label>
                                        <x-input x-model="card_holder_name" id="card_holder_name" name="card_holder_name" type="text" />
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
                            </div>

                        </div>

                        @if(!auth()->user()->subscribed() && !auth()->user()->can('organization-admin'))
                        <div class="mb-4 border border-otgold bg-otgold-100 rounded-md p-4">
                            <span class="font-medium">Attention!</span>
                            Only current members can pay with a credit card.

                            If you would like to pay by credit card today, please <x-a href="{{ route('dashboard.subscribe') }}">subscribe</x-a> to a membership plan.
                        </div>
                        @endif

                        <div class="mb-4">
                            <x-label for="notes">Additional Comments</x-label>
                            <x-textarea id="notes" name="notes" rows="5"></x-textarea>
                        </div>


                        <div class="mb-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="terms_agreement" value="true" x-model="terms_agreement" @change="checkComplete">
                                <i class="fa-regular fa-square text-4xl" x-show="!terms_agreement" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-4xl" x-show="terms_agreement" style="display:none;"></i>
                                <div class="text-lg font-medium leading-tight">
                                    By checking this box I acknowledge the terms of the Ohio Tactical Officers Association
                                    <a href="" class="text-otgold" @click.prevent="termsModal = true">Release of Liability Waiver and Assumption of Risk</a>.
                                </div>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="privacy_policy" value="true" x-model="privacy_policy" @change="checkComplete">
                                <i class="fa-regular fa-square text-4xl" x-show="!privacy_policy" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-4xl" x-show="privacy_policy" style="display:none;"></i>
                                <div class="text-lg font-medium leading-tight">
                                    By checking this box I agree to the OTOA website <a href="" class="text-otgold" @click.prevent="privacyModal = true">Privacy Policy</a>.
                                </div>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="cancellation" value="true" x-model="cancellation" @change="checkComplete">
                                <i class="fa-regular fa-square text-4xl" x-show="!cancellation" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-4xl" x-show="cancellation" style="display:none;"></i>
                                <div class="text-lg font-medium leading-tight">
                                    By checking this box I agree to the <a href="" class="text-otgold" @click.prevent="cancellationModal = true">Payment and Cancellation Policy</a>.
                                </div>
                            </label>
                        </div>

                        <div class="form-group text-center">
                            <button id="card-button" :disabled="!buttonActive" class="w-full px-4 py-1.5 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium px-16">Register</button>
                        </div>
                    </form>

                    <x-modal.plain xshow="termsModal">
                        <div class="prose max-w-full text-sm">
                            {!! $liability->content !!}
                        </div>
                    </x-modal.plain>

                    <x-modal.plain xshow="privacyModal">
                        <div class="prose max-w-full text-sm">
                            {!! $privacy_policy->content !!}
                        </div>
                    </x-modal.plain>

                    <x-modal.plain xshow="cancellationModal">
                        <div class="prose max-w-full text-sm">
                            {!! $cancellation->content !!}
                        </div>
                    </x-modal.plain>


                </div>

                <script type="text/javascript">
                    function payHandler() {
                        return {
                            @can('organization-admin')
                            users: {!! $users !!},
                            user_id: [],
                            available: {{ $trainingCourse->capacity - $trainingCourse->attendees->count() }},
                            total_reg: 0,
                            total_sub: 0,
                            total: 0,
                            price: {{ $trainingCourse->price }},
                            @endcan

                            card_holder_name: '',
                            cc: '',
                            month: '',
                            year: '',

                            terms_agreement: false,
                            termsModal: false,

                            privacy_policy: false,
                            privacyModal: false,

                            cancellation: false,
                            cancellationModal: false,
                            

                            pay: '',
                            pay_type: null,
                            name: null,
                            email: null,
                            card_holder_name: null,
                            buttonActive: false,
                            checkComplete() {
                                this.buttonActive = true;
                                if (this.pay_type == null) {
                                    this.buttonActive = false;
                                }
                                if (this.pay_type == 'invoice') {
                                    if (!this.name) {this.buttonActive = false;}
                                    if (!this.email) {this.buttonActive = false;}
                                }
                                if (this.pay_type == 'credit_card') {
                                    if (!this.card_holder_name) {this.buttonActive = false;}
                                }
                                if (!this.terms_agreement) {this.buttonActive = false;}
                                if (!this.privacy_policy) {this.buttonActive = false;}
                                if (!this.cancellation) {this.buttonActive = false;}
                                
                                @can('organization-admin')
                                if (this.user_id.length == 0) {this.buttonActive = false;}
                                if (this.user_id.length > this.available) {this.buttonActive = false;}

                                this.total_reg = this.user_id.length * this.price;
                                this.total_sub = 0;
                                this.users.forEach(element => {
                                    if (!element.member && this.user_id.includes(element.id.toString())) {
                                        this.total_sub += 30;
                                    }
                                });
                                this.total = this.total_sub + this.total_reg;

                                @endcan

                            },
                            submitForm() {
                                this.buttonActive = false;
                            },
                            
                        }
                    }
                </script>
                @endif

                @endauth
            </div>
        </div>

    </div>



    @endif


</x-site-layout>