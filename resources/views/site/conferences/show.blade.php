<x-site-layout>
    @section("pageTitle")
    {{ $conference->name }}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">{{ $conference->name }}</div>
    </x-banner>

    <div class="flex-1 bg-otsteel" x-data="formHandler()">

        <div class="max-w-7xl bg-white h-full mx-auto p-6 px-4 lg:px-6">

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <div class="hidden font-medium text-3xl mb-4">
                        {{ $conference->start_date->format('l F j') }} - {{ $conference->end_date->format('j | Y') }}
                    </div>
                    <div class="font-medium text-3xl mb-4">
                        {{ $conference->start_date->format('l, F j') }} - {{ $conference->end_date->format('l, F j') }}
                    </div>

                    <div class="prose text-xl max-w-full">
                        {!! $conference->description !!}
                    </div>

                    <div class="mt-10">

                        <div class="mb-6">
                            @php
                            $register = false;
                            if ($conference->registration_active) {$register = true;}
                            if (auth()->user()) {
                            if (auth()->user()->can('general-staff')) {
                            $register = true;
                            }
                            }
                            @endphp
                            @if($register)
                            <div>
                                @auth
                                @if(auth()->user()->conferenceAttendees->where('conference_id', $conference->id)->first() && !auth()->user()->can('organization-admin'))
                                <div class="text-2xl">You are already registered for this conference</div>
                                @else
                                <div class="text-center">
                                    @if(auth()->user()->can('customer') && !auth()->user()->can('civilian') && !auth()->user()->can('general-staff'))
                                    <x-button-link-site class="text-3xl font-medium" href="{{ route('conference.register-choice', $conference) }}">
                                        Register Now
                                    </x-button-link-site>
                                    @else
                                    <x-button-link-site class="text-3xl font-medium" href="{{ route('conference.register', $conference) }}">
                                        Register Now
                                    </x-button-link-site>
                                    @endif
                                </div>
                                @endif
                                @endauth
                                @guest
                                <div class="text-center">
                                    <div class="font-medium text-xl">
                                        You must have a user account to register for this conference.
                                    </div>
                                    <div class="mt-5">
                                        <x-button-link-site href="{{ route('register') }}" class="text-xl">Create User Account</x-button-link-site>
                                    </div>
                                    <div class="mt-3">
                                        <x-a href="{{ route('login') }} ">I already have an account</x-a>
                                    </div>
                                </div>
                                @endguest
                            </div>
                            @else
                            <div class="text-center text-2xl">
                                Conference Attendee Registration
                            </div>
                            <div class="text-center">
                                starts approximately
                            </div>
                            <div class="text-center font-medium text-2xl">
                                {{ $conference->registration_start_date->format('F j, Y')}}
                            </div>
                            @endif
                        </div>
                    </div>


                    @guest
                    <div class="my-8 text-center">
                        <div class="text-3xl">
                            <x-a href="{{ route('login') }}">Login</x-a> or
                            <x-a href="{{ route('register-choice') }}">Register</x-a>
                        </div>
                        <div>to view available conference courses</div>
                    </div>
                    @endguest


                </div>

                <div>
                    @if($conference->venue)
                    <div class="mb-8">
                        @if($conference->venue->image)
                        <img src="/storage/venues/{{ $conference->venue->image }}" />
                        @endif
                        <div class="text-center mt-8">
                            <div>
                                <x-a class="text-2xl" href="{{ route('venue', $conference->venue) }}">{{ $conference->venue->name }}</x-a>
                            </div>
                            <div>
                                {{ $conference->venue->address }}<br>
                                {{ $conference->venue->city }}, {{ $conference->venue->state }} {{ $conference->venue->zip }}<br>
                                {{ $conference->venue->phone }}<br>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="text-center">

                        @if($conference->vendors->where('public')->count() > 0)
                        <div class="mb-8 text-center">
                            <x-a class="text-2xl" href="{{ route('conference.vendors', $conference) }}">
                                View vendor companies
                            </x-a>
                            <div>
                                <a class="" href="{{ route('conference.vendors', $conference) }}">
                                    registered to exhibit at this conference
                                </a>
                            </div>
                        </div>
                        @endif


                        {{-- <div class="mb-8 text-center">
                            Room rates at Kalahari for <strong>EXHIBITORS</strong> begin at $139.00 per night. Visit
                            <div>
                                <x-a class="text-xl" href="https://book.passkey.com/event/50391033/owner/49785631/home" target="_blank">
                                    book.passkey.com
                                </x-a>
                            </div>
                            to reserve your room today
                        </div> --}}



                        @if(!$conference->vendor_active)
                        <div class="text-2xl">
                            Vendor registration is currently not available
                        </div>
                        @else
                        <div>
                            @auth
                            @if(auth()->user()->organization)
                            @if(auth()->user()->organization->vendorRegistrationSubmissions->where('conference_id', $conference->id)->first())
                            <div class="text-semibold bg-otgold-100 border border-otgold p-4">
                                Your company,
                                <span class="font-medium">{{ auth()->user()->organization->name }}</span>,
                                is registered to be a vendor at this conference.
                                You have until {{ $conference->vendor_end_date->format('F j, Y') }} to <x-a href="{{ route('dashboard.vendor-registrations.edit', auth()->user()->organization->vendorRegistrationSubmissions->where('conference_id', $conference->id)->first()) }}">edit your company vendor registration</x-a> if needed.
                            </div>
                            @else
                            <x-button-link-site class="text-xl" href="{{ route('exhibitionRegistration', $conference) }}">
                                Vendor Registration
                            </x-button-link-site>
                            @endif
                            @endif
                            @endauth

                            @guest
                            <x-button-link-site class="text-xl" href="{{ route('exhibitionRegistration', $conference) }}">
                                Vendor Registration
                            </x-button-link-site>
                            @endguest

                        </div>
                        @endif
                    </div>

                </div>
            </div>

            @if($conference->courses_visible)
            @auth
            <div class="xl:flex xl:gap-3 xl:items-center mt-8">
                <div class="font-medium xl:flex-1 xl:text-right">Show Only:</div>
                <div class="">
                    <x-select name="filter" x-model="filter" :selections="$courseTags" placeholder=" " @change="changeFilter" />
                </div>
            </div>
            <div>
                <div class="mb-6">
                    <template x-for="(day, index) in courses" :key="index">
                        <div>
                            <div class="mt-6 pb-2 text-2xl font-medium border-b border-otgray" x-html="index"></div>
                            <template x-for="(course, index2) in day">
                                <div>
                                    {{-- .filter((item) => item.full_name.toLowerCase().includes(value.toLowerCase()))
                                    <div x-text="Object.values(course.course_tags) Object.values(course.course_tags).filter(a=> typeof(a) == 'object').length > 0)"></div> --}}
                                    {{-- <div x-text="Object.values(course.course_tags).filter((item) => item.id == filter).length > 0"></div> --}}
                                    <div x-show="filter ? Object.values(course.course_tags).filter((item) => item.id == filter).length > 0 : true">

                                        <div :class="{'bg-otgray-100 text-otgray': course.disabled}" class="cursor-pointer py-1 px-2 lg:px-3 flex flex-col lg:flex-row lg:gap-3 lg:items-center border-b border-otgray" @click.prevent="showCourse(course)">
                                            <div class="flex-1 lg:order-2">
                                                <div x-html="course.name"></div>
                                                <div x-show="course.parent" class="text-xs text-otsteel font-medium">
                                                    Linked to: <span x-html="course.parent ? course.parent.name : ''"></span>
                                                </div>
                                                <template x-for="child in course.children">
                                                    <div class="text-xs text-otsteel font-medium">Linked to: <span x-html="child.name"></span></div>
                                                </template>
                                            </div>
                                            <div class="font-medium lg:order-1">
                                                <span x-html="course.start_time"></span> -
                                                <span x-html="course.end_time"></span>
                                            </div>
                                            <div class="lg:w-80 lg:order-3">
                                                <template x-for="tag in course.course_tags">
                                                    <div x-text="tag.name" class="text-sm inline-block mr-1 rounded-full bg-otgray px-2 text-white"></div>
                                                </template>
                                            </div>
                                            <div class="lg:w-20 lg:order-4 flex items-center">
                                                <div class="font-bold text-otgray flex-1">
                                                    <span x-show="course.closed">FULL</span>
                                                </div>
                                                <div class="text-xs text-otgray hidden lg:block">
                                                    <span x-html="course.filled"></span>/<span x-html="course.capacity"></span>
                                                </div>
                                            </div>
                                            {{-- <div class="font-semibold text-xl text-right" x-html="course.capacity"></div> --}}
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
            @endauth

            @endif


        </div>


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

    </div>


    <script type="text/javascript">
        function formHandler() {
            return {
                
                filter: null,
                courses: {!! $courses !!},
                courses_all: {!! $conference->courses !!},
                courses_chosen: [],
                course_ids: [],

                courseModal: false,
                courseDisplay: {
                    'description': null,
                    'user_id': null,
                    'profile': null
                },
               
                showCourse(course) {
                    console.log(course);
                    this.courseDisplay = course;
                    this.courseModal = true;
                },
                changeFilter() {
                    console.log(this.filter);
                }
            }
        }
    </script>



</x-site-layout>