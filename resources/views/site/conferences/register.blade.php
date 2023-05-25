<x-site-layout>
    @section("pageTitle")
    {{ $conference->name }} Registration
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Register</div>
    </x-banner>




    @if(request()->get('registration') == 'complete')
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">

            @can('organization-admin')

            @if(\Session::has('registered_user'))
            <div class="font-medium text-xl lg:text-2xl">
                You have registered {!! \Session::get('registered_user') !!} for the {{ $conference->name }}
            </div>
            <div class="mt-4">
                Please notify <span class="font-medium">{!! \Session::get('registered_user') !!}</span>
                to check their email for a registration confirmation with their conference schedule.
            </div>
            @else
            <div class="font-medium text-xl lg:text-2xl">
                You have registered a member of your organization for the {{ $conference->name }}
            </div>
            <div class="mt-4">
                Notify the individual you just registered to check their email for a registration confirmation with their conference schedule.
            </div>
            @endif

            <div class="flex gap-6 items-center justify-center mt-6 text-left">
                <a href="{{ route('dashboard') }}" class="flex gap-2 items-center border border-otgold bg-otgold-100 p-4">
                    <div class="text-otgold">
                        <svg class="w-12 h-12" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-2xl">Dashboard</div>
                        <div class="text-xs leading-none">view your organization</div>
                    </div>
                </a>
                <a href="{{ route('conference.register', $conference) }}" class="flex gap-2 items-center border border-otblue bg-otblue-100 p-4">
                    <div>
                        <x-icons.clipboard class="w-12 h-12 text-otblue" />
                    </div>
                    <div>
                        <div class="font-medium text-2xl">Register Another</div>
                        <div class="text-xs leading-none">for the conference</div>
                    </div>
                </a>
            </div>

            @else
            <div class="font-medium text-2xl lg:text-3xl">
                You have been registered for the {{ $conference->name }}
            </div>
            <div class="mt-4">
                A registration confirmation with your conference schedule has been emailed to you.
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-2 text-center items-center">
                <div class="p-4">
                    <div class="leading-tight">Reserve your room at</div>
                    <div class="font-medium text-2xl">Kalahari</div>
                    <div class="leading-tight">on</div>
                    <div>
                        <x-a class="text-2xl" href="https://book.passkey.com/event/50439177/owner/49785631/home" target="_blank">book.passkey.com</x-a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="leading-tight">Find more lodging options on our</div>
                    <div>
                        <x-a class="text-2xl" href="https://otoa.org/conference-hotels">Conference Hotels</x-a>
                    </div>
                    <div class="leading-tight">page</div>
                </div>
                <div class="p-4">
                    <div class="leading-tight">Find more info on your</div>
                    <div>
                        <x-a class="text-2xl" href="https://otoa.org/dashboard">Dashboard</x-a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="leading-tight">Need to make changes? Email us at</div>
                    <div>
                        <x-a class="text-2xl" href="mailto:training@otoa.org" target="_blank">training@otoa.org</x-a>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>

    @elseif(request()->get('registration') == 'found')

    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">

            <div class="font-medium text-xl lg:text-2xl">
                You have already registered for the {{ $conference->name }}
            </div>
            <div class="mt-4">
                If you need to make changes please contact office@otoa.org.
            </div>

        </div>
    </div>

    @else

    @php
    $register = false;
    if ($conference->registration_active) {$register = true;}
    if (auth()->user()) {
    if (auth()->user()->can('general-staff')) {
    $register = true;
    }
    }
    @endphp
    @if(!$register)
    <div class="flex-1 bg-otsteel px-4 py-8">
        <div class="p-6 max-w-3xl mx-auto bg-white shadow text-center">
            <div class="font-medium text-2xl lg:text-3xl">
                Registration currently not available for this conference
            </div>
        </div>
    </div>
    @else

    <section x-data="formHandler()" class="flex-1 bg-otsteel">

        {{-- @livewire('files-upload', ['uploadNum' => 2, 'main_id' => 1, 'folder' => 'vendor-logos', 'uploads' => null ]) --}}


        <div class="max-w-7xl h-full mx-auto bg-white shadow">

            <div class="lg:flex lg:gap-6">
                <div class="flex-1 p-6 px-4 lg:px-6">

                    <x-form-errors />


                    <div class="text-3xl font-medium mb-4">Conference Registration</div>


                    @cannot('organization-admin')
                    <div class="mb-8">
                        <div>
                            <div class="flex mb-4">
                                <div class="w-12 text-center font-medium text-4xl pt-1">1</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Select your courses</div>
                                    <div class="text-sm leading-tight text-otgray">Select the courses you would like to attend.</div>
                                </div>
                            </div>
                            {{-- <div class="flex mb-4">
                                <div class="w-12 text-center font-medium text-4xl pt-1">2</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Select your payment method</div>
                                    <div class="text-sm leading-tight text-otgray">Select if we'll invoice you or if you'll be paying by credit card.</div>
                                </div>
                            </div> --}}
                            <div class="flex mb-4">
                                <div class="w-12 text-center font-medium text-4xl pt-1">2</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Review your courses</div>
                                    <div class="text-sm leading-tight text-otgray">Make sure you selected all the correct courses.</div>
                                </div>
                            </div>
                            <div class="flex mb-4">
                                <div class="w-12 text-center font-medium text-4xl pt-1">3</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Provide invoice details</div>
                                    <div class="text-sm leading-tight text-otgray">
                                        {{-- You can only pay by credit card if you are currently subscibed to a membership plan.
                                        If you want to be invoiced, please provide the name and email of the person that will receive the invoice. --}}
                                        Provide the name and email of the person that will receive the invoice.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcannot

                    @can('organization-admin')
                    <div class="mb-8">
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-12 text-center font-medium text-4xl">1</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Select member to register</div>
                                    <div class="text-sm leading-tight text-otgray">
                                        Member <span class="font-medium">NOT</span> listed? <x-a href="{{ route('dashboard.organization.user-create', ['redirect' => 'conference']) }}">Add user.</x-a>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center mb-4">
                                <div class="w-12 text-center font-medium text-4xl">2</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Select your courses</div>
                                    {{-- <div class="text-sm leading-tight text-otgray">Select the courses you would like your member to attend.</div> --}}
                                </div>
                            </div>
                            {{-- <div class="flex items-center mb-4">
                                <div class="w-12 text-center font-medium text-4xl">3</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Select your payment method</div>
                                    <div class="text-sm leading-tight text-otgray">As an organization admin you can only be invoiced for conference registration.</div>
                                </div>
                            </div> --}}
                            <div class="flex items-center mb-4">
                                <div class="w-12 text-center font-medium text-4xl">3</div>
                                <div class="flex-1">
                                    <div class="text-xl leading-tight">Provide invoice details</div>
                                    <div class="text-sm leading-tight text-otgray">
                                        Provide the name and email of the person that will receive the invoice.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="text-3xl font-medium">Select member to register</div>
                    <div class="mb-4">
                        You can only register one member of your organization at a time.
                    </div>

                    <div class="mb-4">
                        @include('site.dashboard.organization.organization-chooser')
                    </div>

                    <div class="md:columns-2 md:gap-2 my-6">
                        <template x-for="(user, index) in users" :key="index">
                            <div class="break-inside-avoid border border-otgray rounded-md mb-2" :class="{'bg-otgray-100' : user.registered, 'bg-white' : user.id == user_id}">
                                {{-- :class="{[card.someOtherClass]: true, 'bg-green-500': index > 3 }" --}}
                                <label class="flex gap-2 items-center px-3 py-1">
                                    <input type="radio" form="main-form" name="user_id" x-model="user_id" :value="user.id" @change="checkComplete" class="disabled:bg-otgray-200" :disabled="user.registered" />

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



                    @endcan

                    {{-- @if(auth()->user()->conferenceAttendees->where('conference_id', $conference->id)->first())
                    <div class="font-semibold">Registered</div>
                    @endif --}}


                    <div class="text-3xl font-medium mt-8">Choose your courses</div>
                    <div class="mb-6">
                        <template x-for="(day, index) in courses" :key="index">
                            <div>
                                <div class="mt-6 mb-2 text-2xl font-medium" x-html="index"></div>
                                <template x-for="(course, index2) in day">
                                    <label :class="{'bg-otgray-100 text-otgray': course.disabled, 'border-t': index2 ==0 }" class="py-1 px-3 flex gap-3 items-center border-b border-otblue-300">
                                        <input type="checkbox" form="main-form" class="disabled:bg-otgray-100 disabled:border-otgray-300" x-model="course_ids" name="course_ids[]" :disabled="course.disabled == true" :value="course.id" @change="chooseCourse(course)" />
                                        <div class="flex-1 flex flex-col lg:flex-row lg:gap-3 lg:items-center">
                                            <div class="flex-1">
                                                <div x-html="course.name" class=""></div>
                                                <div x-show="course.parent" class="text-xs text-otsteel font-medium">
                                                    Linked to: <span x-html="course.parent ? course.parent.name : ''"></span>
                                                </div>
                                                <template x-for="child in course.children">
                                                    <div class="text-xs text-otsteel font-medium">Linked to: <span x-html="child.name"></span></div>
                                                </template>
                                            </div>
                                            <div x-show="course.closed" class="font-bold text-otgray">
                                                FULL
                                            </div>

                                            @can('civilian')
                                            <div x-show="course.restricted" class="font-bold text-otgray">
                                                NO CIVILIANS
                                            </div>
                                            @endcan

                                            <div class="text-xs text-otgray hidden lg:block">
                                                <span x-html="course.filled"></span>/<span x-html="course.capacity"></span>
                                            </div>
                                            <div class="flex gap-2 items-center">
                                                <div class="text-sm font-medium flex-1">
                                                    <span x-html="course.start_time"></span> -
                                                    <span x-html="course.end_time"></span>
                                                </div>
                                                <div class="">
                                                    <a href="" class="text-otgold" @click.prevent="showCourse(course)"><i class="fa-solid fa-circle-info" title="Course Description"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </template>
                    </div>






                </div>



                <div class="lg:w-96 bg-otgray-200 p-6">
                    <div class="sticky top-4">
                        <form method="POST" id="main-form" action="{{ route('conference.registerPost', $conference) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="text-3xl font-medium text-center mb-4">
                                Payment Information
                            </div>
                            {{-- <div class="mb-4 text-center">
                                Something about paying here
                            </div> --}}

                            @can('organization-admin')
                            <div class="mb-4">
                                Registering:
                                <template x-if="user_id">
                                    <span class="font-medium" x-text="users[users.findIndex(item => item.id == user_id)].name"></span>
                                </template>
                                <template x-if="!user_id">
                                    <span class="text-otgray">Select Member</span>
                                </template>
                            </div>
                            @endcan

                            <div class="rounded-lg bg-white px-4 py-3 mb-4">
                                <div x-show="courses_chosen.length == 0" class="text-otgray text-center font-light">
                                    You must first select some courses
                                </div>
                                <div x-show="courses_chosen.length > 0">
                                    <template x-for="(course, index) in courses_chosen" :key="index">
                                        <div :class="index > 0 ? 'border-t border-otgray' : ''">
                                            <div x-html="course.name" class="py-1 text-sm leading-tight"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div x-show="total == 0" class="hidden text-center mb-4">
                                <div class="text-xl text-otgray">You must first select some courses.</div>
                            </div>

                            <div x-show="total > 0" class="text-center mb-4" style="display:none;">
                                <div class="font-semibold text-3xl">$<span x-html="total"></span></div>
                                <div class="font-medium" x-html="package"></div>
                                <div x-show="!subscribed">
                                    <div><span class="font-medium">+ $30</span> for membership</div>
                                    <div class="font-medium text-xl">$<span x-text="total + 30"></span> Total</div>
                                </div>
                            </div>

                            <div class="">
                                <div class="border border-otgray rounded-md overflow-hidden bg-white">
                                    <label class="flex px-4 py-2 gap-4 bg-otgray-300 items-center">
                                        <input type="radio" name="pay_type" x-model="pay_type" value="invoice" @change="checkComplete" />
                                        <div class="flex-1">
                                            <div class="font-bold text-xl">Invoice Me</div>
                                            <div class="">Invoices can be paid by check or credit card</div>
                                        </div>
                                    </label>
                                    <div x-show="pay_type == 'invoice'" class="p-4">
                                        <div class="mb-4 text-sm">
                                            All registrations are invoiced and payable by check or credit card.
                                            <strong>IMPORTANT</strong> - List the person that <span class="font-medium">RECEIVES INVOICES FOR PAYMENT</span>.
                                            {{-- If you are not paying the invoice, <span class="font-medium">DO NOT</span> enter your information. --}}
                                        </div>
                                        <div class="mb-4">
                                            <x-label for="name">Name</x-label>
                                            <x-input id="name" name="name" x-model="name" @change="checkComplete" />
                                        </div>
                                        <div class="mb-4">
                                            <x-label for="email">Email</x-label>
                                            <x-input id="email" name="email" type="email" x-model="email" @change="checkComplete" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 border border-otgray rounded-md overflow-hidden bg-white {{ (!auth()->user()->subscribed() || auth()->user()->can('organization-admin')) ? 'opacity-50' : '' }}">
                                    <label class="flex px-4 py-2 gap-4 bg-otgray-300 items-center">
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
                                        <div class="">
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

                            <div>
                                <div class="mt-4">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" class="hidden" name="terms_agreement" value="true" x-model="terms_agreement" @change="checkComplete">
                                        <i class="fa-regular fa-square text-xl" x-show="!terms_agreement" style="display:none;"></i>
                                        <i class="fa-regular fa-square-check text-xl" x-show="terms_agreement" style="display:none;"></i>
                                        <div class="text-sm font-medium leading-tight">
                                            I acknowledge the terms of the
                                            <a href="" class="text-otgold" @click.prevent="termsModal = true">Liability Waiver</a>.
                                        </div>
                                    </label>
                                </div>

                                <div class="">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" class="hidden" name="privacy_policy" value="true" x-model="privacy_policy" @change="checkComplete">
                                        <i class="fa-regular fa-square text-xl" x-show="!privacy_policy" style="display:none;"></i>
                                        <i class="fa-regular fa-square-check text-xl" x-show="privacy_policy" style="display:none;"></i>
                                        <div class="text-sm font-medium leading-tight">
                                            I agree to the OTOA website <a href="" class="text-otgold" @click.prevent="privacyModal = true">Privacy Policy</a>.
                                        </div>
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" class="hidden" name="cancellation" value="true" x-model="cancellation" @change="checkComplete">
                                        <i class="fa-regular fa-square text-xl" x-show="!cancellation" style="display:none;"></i>
                                        <i class="fa-regular fa-square-check text-xl" x-show="cancellation" style="display:none;"></i>
                                        <div class="text-sm font-medium leading-tight">
                                            I agree to the <a href="" class="text-otgold" @click.prevent="cancellationModal = true">Cancellation Policy</a>.
                                        </div>
                                    </label>
                                </div>
                            </div>



                            <div class="text-center mt-4">

                                <input type="hidden" name="total" x-model="total">
                                <input type="hidden" name="package" x-model="package">
                                <button @click.prevent="submitData" id="card-button" :disabled="!buttonActive" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl">
                                    Process Registration
                                </button>

                                <div class="text-xm text-otgray mt-4 px-10" x-show="!buttonActive">
                                    Please complete the entire form to submit your registration.
                                </div>
                            </div>

                            <input type="hidden" id="refreshed" value="no" />
                            <script type="text/javascript">
                                window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});
                            //     onload=function(){ 
                            //         console.log('ONLOAD');
                            //     var e=document.getElementById("refreshed"); 
                            //     if (e.value=="no") {
                            //         e.value="yes"; 
                            //     } else {
                            //         e.value="no";
                            //         location.reload();
                            //     } 
                            // } 
                            </script>



                        </form>
                    </div>
                </div>

            </div>

        </div>


        <x-modal.plain xshow="termsModal">
            <div class="font-medium text-xl mb-4">Release of Liability Waiver and Assumption of Risk</div>
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

        <x-modal.plain xshow="courseModal">
            <div class="md:flex md:gap-3">
                <div class="md:flex-1">
                    <div x-html="courseDisplay.name" class="font-medium text-2xl"></div>
                    <div x-html="courseDisplay.date_display" class="font-medium text-lg"></div>
                    <div class="mb-4">
                        <span x-html="courseDisplay.start_time"></span> -
                        <span x-html="courseDisplay.end_time"></span>
                    </div>
                    <div class="mb-4">
                        <template x-for="tag in courseDisplay.course_tags">
                            <div x-text="tag.name" class="text-sm inline-block mr-1 rounded-full bg-otgray px-2 text-white"></div>
                        </template>
                    </div>
                    <div x-show="courseDisplay.venue" class="mb-4">
                        <div class="font-medium text-xl">Venue</div>
                        <div>
                            <a class="font-medium text-otgold" :href="'/venues/' + (courseDisplay.venue ? courseDisplay.venue.slug : '')" x-html="courseDisplay.venue ? courseDisplay.venue.name : ''"></a>
                        </div>
                        <div x-html="courseDisplay.location" class="font-medium"></div>
                        @auth
                        <div x-html="courseDisplay.venue ? courseDisplay.venue.address : ''"></div>
                        @endauth
                        <div>
                            <span x-html="courseDisplay.venue ? courseDisplay.venue.city : ''"></span>,
                            <span x-html="courseDisplay.venue ? courseDisplay.venue.state : ''"></span>
                            <span x-html="courseDisplay.venue ? courseDisplay.venue.zip : ''"></span>
                        </div>
                    </div>
                    <div x-show="courseDisplay.description" class="mb-4">
                        <div class="font-medium text-xl">Course Description</div>
                        <div x-html="courseDisplay.description" class="prose text-base max-w-full"></div>
                    </div>
                    <div x-show="courseDisplay.requirements" class="mb-4">
                        <div class="font-medium text-xl">Student Requirements</div>
                        <div x-html="courseDisplay.requirements" class="prose text-base max-w-full"></div>
                    </div>
                </div>
                <div class="md:w-40 md:text-center">
                    <div class="font-medium text-xl">Instructor</div>
                    <div x-show="courseDisplay.user_id">
                        <a class="font-medium text-otgold" :href="'/staff/' + (courseDisplay.user ? courseDisplay.user.id: '')">
                            <img class="w-40 rounded-full" :src="courseDisplay.instructor_image" />
                            <div x-html="courseDisplay.user ? courseDisplay.user.name : ''"></div>
                        </a>
                    </div>
                    <div x-show="!courseDisplay.user_id">
                        <div><img class="w-40 rounded-full" src="/storage/profile/no-image.png" /></div>
                        <div class="font-medium">No Instructor Chosen</div>
                    </div>
                    <template x-if="courseModal">
                        <div x-show="Object.keys(courseDisplay.users).length">
                            <div class="mt-6 font-medium text-xl">Other Instructors</div>
                            <template x-for="user in courseDisplay.users">
                                <div>
                                    <a class="font-medium text-otgold" :href="'/staff/' + user.id">
                                        <div x-text="user.name"></div>
                                    </a>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </x-modal.plain>

        <x-modal.plain xshow="errorModal">
            <div x-html="errorMessage" class="prose text-base max-w-full"></div>
        </x-modal.plain>


    </section>


    <script type="text/javascript">
        function formHandler() {
            return {
                
                @can('organization-admin')
                users: {!! $users !!},
                user_id: null,
                total_reg: 0,
                total_sub: 0,
                total: 0,
                subscribed: false,
                @else
                subscribed: {{ auth()->user()->subscribed() ? 'true' : 'false' }},
                @endcan
                
                pay: '',
                pay_type: null,
                name: null,
                email: null,

                card_holder_name: '',
                cc: '',
                month: '',
                year: '',
                
                courses: {!! $courses !!},
                courses_all: {!! $conference->courses !!},
                courses_chosen: [],
                course_ids: [],

                daysSelected: 0,
                daysSelectedArray: [],
                total: 0,
                package: null,

                company_name: null,
                company_website: null,

                courseModal: false,
                errorModal: false,
                errorMessage: null,
    
                terms_agreement: false,
                termsModal: false,

                privacy_policy: false,
                privacyModal: false,

                cancellation: false,
                cancellationModal: false,

                buttonActive: false,
                courseDisplay: {
                    'description': null,
                    'user_id': null,
                    'profile': null
                },
                init() {
                    // this.checkComplete();
                    this.markDisabled();
                },
                showCourse(course) {
                    console.log(course);
                    this.courseModal = true;
                    this.courseDisplay = course;
                },

                checkComplete() {
                    this.buttonActive = true;
                    if (!this.terms_agreement) {this.buttonActive = false;}
                    if (!this.privacy_policy) {this.buttonActive = false;}
                    if (!this.cancellation) {this.buttonActive = false;}
                    // console.log(Object.keys(this.course_ids).length);
                    if (!Object.keys(this.course_ids).length) {
                        this.buttonActive = false;
                    }
                    if (this.pay_type == null) {
                        this.buttonActive = false;
                    }
                    if (this.pay_type == 'invoice') {
                        if (this.name == null) {
                            this.buttonActive = false;
                        }
                        if (this.email == null) {
                            this.buttonActive = false;
                        }
                    }
                    if (this.pay_type == 'credit_card') {
                        if (this.card_holder_name == null) {
                            this.buttonActive = false;
                        }
                        if (this.cc == null) {
                            this.buttonActive = false;
                        }
                        if (this.month == null) {
                            this.buttonActive = false;
                        }
                        if (this.year == null) {
                            this.buttonActive = false;
                        }
                    }
                    @can('organization-admin')
                    if (this.user_id == null) {
                        this.buttonActive = false;
                    }
                    if (this.user_id) {
                        this.subscribed = this.users[this.users.findIndex(item => item.id == this.user_id)].member;
                    }
                    @endcan
                    this.checkDaysSelected();
                },

                
                checkDaysSelected() {
                    this.daysSelected = 0;
                    Object.values(this.courses).forEach((day, index) => {
                        // day.selected = 0;
                        // console.log(this.courses);
                        this.daysSelectedArray[index] = 0;
                        Object.values(day).forEach(course => {
                            // console.log(course.id);
                            if (Object.values(this.course_ids).includes(course.id.toString())) {
                                this.daysSelected++;
                                this.daysSelectedArray[index]++;
                            }
                            
                        });
                    });

                    this.total = 0;
                    this.package = null;

                    if (this.daysSelectedArray[0] > 0 || this.daysSelectedArray[1] > 0 || this.daysSelectedArray[2] > 0 || this.daysSelectedArray[3] > 0 || this.daysSelectedArray[4] > 0) {
                        this.total = 350;
                        this.package = "Full Conference";
                    }
                    if ((this.daysSelectedArray[0] > 0 || this.daysSelectedArray[1] > 0) && this.daysSelectedArray[2] == 0 && this.daysSelectedArray[3] == 0 && this.daysSelectedArray[4] == 0) {
                        this.total = 150;
                        this.package = "Monday & Tuesday Package";
                    }
                    if ((this.daysSelectedArray[2] > 0 || this.daysSelectedArray[3] > 0) && this.daysSelectedArray[0] == 0 && this.daysSelectedArray[1] == 0 && this.daysSelectedArray[4] == 0) {
                        this.total = 300;
                        this.package = "Wednesday & Thursday Package";
                    }
                    if ((this.daysSelectedArray[3] > 0 || this.daysSelectedArray[4] > 0) && this.daysSelectedArray[0] == 0 && this.daysSelectedArray[1] == 0 && this.daysSelectedArray[2] == 0) {
                        this.total = 300;
                        this.package = "Thursday & Friday Package";
                    }

                    console.log(this.daysSelectedArray);
                },

                formData: {
                    course_ids: [],
                    _token: document.head.querySelector('meta[name=csrf-token]').content
                },
                submitData() {
                    
                    console.log('submitData');

                    this.formData.course_ids = this.course_ids;
                               
                    
                    fetch('{{ route('checkCourses') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.formData)
                    })
                    .then(response => response.json())
                    .then((data) => {
                        // this.message = 'Form sucessfully submitted!';
                        console.log(data);

                        console.log(JSON.stringify(data));

                        if (!data.length) {
                            // window.dispatchEvent(new Event('processRegistration'));
                            
                            var form = document.getElementById('main-form');
                            form.submit();
                        } else {

                            badCourses = "";
                            data.forEach(obj => {
                                // Object.entries(obj).forEach(([key, value]) => {
                                //     console.log(`${key} ${value}`);
                                // });
                                console.log(obj.id);
                                console.log('-------------------');

                                Object.values(this.courses).forEach((day, index) => {
                                    // day.selected = 0;
                                    // console.log(this.courses);
                                    this.daysSelectedArray[index] = 0;
                                    Object.values(day).forEach(course => {
                                        // console.log(course.id);
                                        if (course.id == obj.id) {
                                            this.course_ids.splice(Object.keys(this.course_ids).find(key => this.course_ids[key] === course.id.toString()), 1);
                                            course.filled = obj.filled;
                                            course.capacity = obj.capacity;
                                            course.closed = true;
                                            course.disabled = true;
                                            badCourses = badCourses + obj.name + "<br>";
                                        }
                                        
                                    });
                                });

                                this.errorMessage = "<p><strong>The following courses you selected have been filled:</strong><br>" + badCourses + "</p>"
                                    + "<p>These courses have been deselected. Please choose another course.</p>";
                                this.errorModal = true;



                            // });
                            // console.log(data.fileName);
                            // this.fields.push(data);
                            // this.fields.push({
                            //     details: 'details line',
                            //     note: this.formData.new_note,
                            //     image: '<span class="text-red-900">hello</span>'
                            });

                            this.markDisabled();
                            // this.formData.new_note = '';
                        }
                            
                    })
                    .catch(() => {
                        // this.message = 'Ooops! Something went wrong!'
                    })
                    .finally(() => {
                        // this.loading = false;
                        // this.buttonLabel = 'Add Note';
                    });

                    // window.dispatchEvent(new Event('processRegistration'));
                },

                chooseCourse(checked_course) {
                    this.courses_chosen = [];
                    

                    if (Object.values(this.course_ids).includes(checked_course.id.toString())) {
                        // checked box on

                        if (checked_course.link_id != null) {
                            // if checked box is the child element

                            // turn on parent
                            this.course_ids.push(checked_course.link_id.toString());

                            // turn on other children
                            Object.values(this.courses).forEach(day => {
                                Object.values(day).forEach(course => {
                                    if(course.id != checked_course.id) {
                                        if (course.link_id == checked_course.link_id) {
                                            this.course_ids.push(course.id.toString());
                                        }
                                    }
                                });
                            });
                        } else {
                            // if checked box is the parent element
                            Object.values(this.courses).forEach(day => {
                                Object.values(day).forEach(course => {
                                    if (course.link_id == checked_course.id) {
                                        this.course_ids.push(course.id.toString());
                                    }
                                });
                            });
                        }
                    } else {
                        // checked box off

                        if (checked_course.link_id != null) {
                            // if checked box is the child element

                            // turn off parent
                            console.log("parent" + Object.keys(this.course_ids).find(key => this.course_ids[key] === checked_course.link_id.toString()));
                            this.course_ids.splice(Object.keys(this.course_ids).find(key => this.course_ids[key] === checked_course.link_id.toString()), 1);
                           
                            // turn off other children
                            Object.values(this.courses).forEach(day => {
                                Object.values(day).forEach(course => {
                                    if (course.link_id != null) {
                                        console.log(course.link_id);    
                                        if (course.link_id == checked_course.link_id) {        
                                            index = Object.keys(this.course_ids).find(key => this.course_ids[key] === course.id.toString())   
                                            if (index >= 0) {
                                                this.course_ids.splice(index, 1);
                                            }
                                        }
                                    }
                                });
                            });

                        } else {
                            // if checked box is the parent element

                            Object.values(this.courses).forEach(day => {
                                Object.values(day).forEach(course => {
                                    if (course.link_id == checked_course.id) {
                                        this.course_ids.splice(Object.keys(this.course_ids).find(key => this.course_ids[key] === course.id.toString()), 1);
                                    }
                                });
                            });
                        }

                    }
                    console.log(this.course_ids);
                    this.markDisabled();
                },

                markDisabled() {
                    console.log('marking disabled');

                    // reset all disabled fields
                    Object.values(this.courses).forEach(day => {
                        Object.values(day).forEach(course => {
                            course.disabled = false;
                        });
                    });

                    this.course_ids.forEach((element) => {
                        obj = this.courses_all.find(data => data.id == element);
                        this.courses_chosen.push(obj);

                        Object.values(this.courses).forEach(day => {
                            Object.values(day).forEach(course => {
                                if (course.id != obj.id) {
                                    if (obj.start_date <= course.start_date && obj.end_date > course.start_date) {
                                        course.disabled = true;
                                    } // b starts in a
                                    if (obj.start_date < course.end_date   && obj.end_date >= course.end_date ) {
                                        course.disabled = true;
                                    } // b ends in a
                                    if (obj.start_date > course.start_date && obj.end_date < course.end_date) {
                                        course.disabled = true;
                                    } // a in b
                                }
                            });
                        });
                    });

                    Object.values(this.courses).forEach(day => {
                        Object.values(day).forEach(course => {
                            // console.log('disabled loop');
                            // console.log('course disabled' + course.disabled);
                            if (course.disabled == true) {
                                if (course.link_id != null) {
                                    console.log('FOUND' + course.link_id);
                                    Object.values(this.courses).forEach(day2 => {
                                        Object.values(day2).forEach(course2 => {
                                            if (course2.id == course.link_id) {
                                                course2.disabled = true;
                                            }
                                        });
                                    });
                                } else {
                                    Object.values(this.courses).forEach(day2 => {
                                        Object.values(day2).forEach(course2 => {
                                            if (course2.link_id == course.id) {
                                                course2.disabled = true;
                                            }
                                        });
                                    });

                                }
                            }

                        });
                    });

                    Object.values(this.courses).forEach(day => {
                        Object.values(day).forEach(course => {
                            if (course.closed == true) {
                                course.disabled = true;
                            }
                            @can('civilian')
                            if (course.restricted == true) {
                                course.disabled = true;
                            }
                            @endcan

                        });
                    });

                    this.checkComplete();

                    


                },
            }
        }
    </script>

    @endif
    @endif










</x-site-layout>