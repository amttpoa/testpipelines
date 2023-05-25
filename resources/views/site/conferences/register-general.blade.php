<x-site-layout>
    @section("pageTitle")
    {{ $conference->name }} Registration
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Register</div>
        <div class="text-xl lg:text-2xl">General Session</div>
    </x-banner>


    <div x-data="formHandler()">
        <div class="flex-1 bg-otsteel">
            <div class="max-w-6xl bg-white h-full mx-auto p-6">

                @php
                $course = $conference->freeCourse;
                @endphp
                <div class="lg:flex lg:gap-4">
                    <div class="lg:flex-1 mb-6">
                        <div class="font-medium text-2xl">{{ $course->name }}</div>
                        <div class="font-medium text-lg">
                            {{ $course->start_date->format('F j, Y') }}
                            <span class="ml-3 text-otgray">
                                {{ $course->start_date->format('H:i') }} -
                                {{ $course->end_date->format('H:i') }}
                            </span>
                        </div>
                        <div class="mb-4">
                            @foreach($course->courseTags as $tag)
                            <div class="text-sm inline-block mr-1 rounded-full bg-otgray px-2 text-white">{{ $tag->name }}</div>
                            @endforeach
                        </div>
                        @if($course->venue)
                        <x-a class="text-xl" href="{{ route('venue', $course->venue) }}">
                            {{ $course->venue->name }}
                        </x-a>
                        @endif
                        <div class="font-medium">
                            {{ $course->location }}
                        </div>
                        @if($course->venue)
                        @guest
                        <x-a href="{{ route('login') }}">Login</x-a> to see address
                        @endguest
                        @auth
                        <div>{{ $course->venue->address }}</div>
                        @endauth
                        <div>
                            {{ $course->venue->city }},
                            {{ $course->venue->state }}
                            {{ $course->venue->zip }}
                        </div>
                        @endif

                    </div>
                    @if($course->user)
                    <div class="mb-6">
                        <div class="text-center">
                            <a class="text-center inline-block" href="{{ route('staffProfile', $course->user) }}">
                                <x-profile-image class="w-40 h-40 inline" :profile="$course->user->profile" />
                                <div class="font-medium text-xl">{{ $course->user->name }}</div>
                                <div class="text-otgray">
                                    {{ $course->user->profile->title }}
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($course->users->isNotEmpty())
                    <div class="lg:max-w-md mb-6 flex flex-wrap justify-center gap-3 lg:mt-10">
                        @foreach($course->users as $user)
                        <div class="text-center w-28">
                            <a class="text-center inline-block" href="{{ route('staffProfile', $user) }}">
                                <x-profile-image class="w-20 h-20 inline" :profile="$user->profile" />
                                <div class="font-medium mt-2 leading-tight">{{ $user->name }}</div>
                                <div class="text-otgray text-sm leading-tight mt-1">
                                    {{ $user->profile->title }}
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <h2 class="text-2xl">Course Description</h2>
                <div class="prose max-w-full mb-6">
                    {!! $course->description !!}
                </div>

                <h2 class="text-2xl mt-6">Student Requirements</h2>
                <div class="prose max-w-full mb-6">
                    {!! $course->requirements !!}
                </div>




                @guest
                <div class="text-lg text-center">
                    <div class="text-2xl">
                        <x-a href="{{ route('login') }}">Login</x-a> or <x-a href="{{ route('register-choice') }}">Sign Up</x-a>
                    </div>
                    <div>to register for the General Session</div>
                </div>
                @endguest

                @auth



                @if(auth()->user()->conferenceAttendees->where('conference_id', $conference->id)->first())
                <x-callouts.info>You are registered for this conference.</x-callouts.info>
                @else
                <div class="text-2xl mt-6">Register for the General Session</div>
                <form method="POST" x-data="{buttonActive:false}" action="{{ route('conference.register-general-session', $conference) }}">
                    @csrf
                    <div class="mt-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="hidden" name="attend" value="true" x-model="attend" @change="checkComplete">
                            <i class="fa-regular fa-square text-4xl" x-show="!attend" style="display:none;"></i>
                            <i class="fa-regular fa-square-check text-4xl" x-show="attend" style="display:none;"></i>
                            <div class="text-lg font-medium leading-tight">
                                I, {{ auth()->user()->name }}, want to attend the General Session
                            </div>
                        </label>
                    </div>


                    <div class="ml-2 mt-2">
                        <div class="">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="terms_agreement" value="true" x-model="terms_agreement" @change="checkComplete">
                                <i class="fa-regular fa-square text-xl" x-show="!terms_agreement" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-xl" x-show="terms_agreement" style="display:none;"></i>
                                <div class="text-sm font-medium leading-tight ml-2">
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
                                <div class="text-sm font-medium leading-tight ml-2">
                                    I agree to the OTOA website <a href="" class="text-otgold" @click.prevent="privacyModal = true">Privacy Policy</a>.
                                </div>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="hidden" name="cancellation" value="true" x-model="cancellation" @change="checkComplete">
                                <i class="fa-regular fa-square text-xl" x-show="!cancellation" style="display:none;"></i>
                                <i class="fa-regular fa-square-check text-xl" x-show="cancellation" style="display:none;"></i>
                                <div class="text-sm font-medium leading-tight ml-2">
                                    I agree to the <a href="" class="text-otgold" @click.prevent="cancellationModal = true">Cancellation Policy</a>.
                                </div>
                            </label>
                        </div>
                    </div>


                    <button :disabled="!buttonActive" disabled class="mt-4 w-full px-4 py-1.5 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium px-16">Register</button>

                </form>
                @endif


                @endauth


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

    </div>

    <script type="text/javascript">
        function formHandler() {
            return {
                attend: false,
                    
                terms_agreement: false,
                termsModal: false,

                privacy_policy: false,
                privacyModal: false,

                cancellation: false,
                cancellationModal: false,

                buttonActive: false,
                checkComplete() {
                    this.buttonActive = true;
                    if (!this.attend) {this.buttonActive = false;}
                    if (!this.terms_agreement) {this.buttonActive = false;}
                    if (!this.privacy_policy) {this.buttonActive = false;}
                    if (!this.cancellation) {this.buttonActive = false;}
                  
                },
            }
        }
    </script>


</x-site-layout>