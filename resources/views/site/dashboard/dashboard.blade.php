<x-dashboard.layout class="px-0 py-0 sm:px-0 sm:py-0">
    @section("pageTitle")
    Dashboard
    @endSection



    <div class="lg:flex h-full">
        <div class="lg:flex-1 p-4 sm:p-6">

            @if(request()->get('subscription') == 'created' or \Session::has('subscription'))
            <div class="flex gap-6 items-center mb-4 text-semibold bg-otgold-100 border border-otgold rounded-xl p-6">
                <div class="flex-1">
                    <div class="font-medium text-2xl text-otgold">Membership Information</div>
                    <strong>Congratulations!</strong> You are a member of the largest state tactical training organization in the country.
                </div>
            </div>
            @endif


            @if(request()->get('subscription') == 'started')
            <div class="flex gap-6 items-center mb-4 text-semibold bg-otgold-100 border border-otgold rounded-xl p-6">
                <x-icons.warning class="w-16 h-16 text-otgold" />
                <div class="flex-1">
                    <div class="font-medium text-2xl">Attention!!</div>
                    <div class="font-medium text-lg">Membership Information</div>
                    You have been given a one year standard membership.
                </div>
            </div>
            @endif


            {{-- WARNINGS --}}

            @cannot('organization-admin')
            @canany(['customer', 'general-staff'])
            @if(!auth()->user()->subscribed())
            <div class="flex gap-6 items-center mb-6 text-semibold bg-otgold-100 border border-otgold rounded-xl p-6">
                <x-icons.warning class="w-16 h-16 text-otgold" />
                <div class="flex-1">
                    <div class="font-bold text-3xl text-otgold">Attention!!</div>
                    <div>
                        <div class="mb-4">
                            If you registered for training and <span class="font-medium">DO NOT</span> have a current membership, we will add the membership fee to your training invoice AND assign you to a membership plan.
                        </div>
                        <div>If you <span class="font-medium">ONLY</span> signed up for a user profile, <x-a href="{{ route('dashboard.subscribe') }}">join now</x-a>. OTOA Membership required to attend OTOA training.</div>
                    </div>
                </div>
            </div>
            @endif
            @endcanany
            @endcannot



            @can('hotel-request-form')
            @foreach($upcomingConferences as $conference)
            @if(auth()->user()->conferenceHotelRequests->where('conference.id', $conference->id)->isEmpty())
            <div class="flex gap-6 items-center mb-6 text-semibold bg-otblue-100 border border-otblue rounded-xl p-6">
                <div class="text-center">
                    @can('staff')
                    <div class="text font-bold text-center">Staff</div>
                    @elsecan('conference-instructor')
                    <div class="text font-bold text-center leading-none">
                        <div>Conference</div>
                        <div>Instructors</div>
                    </div>
                    @else
                    <div class="text font-bold text-center">VIPs</div>
                    @endif
                    <x-icons.finger-gun class="w-10 h-10 text-otblue inline-block" />
                </div>
                <div class="flex-1">
                    <div class="font-medium text-2xl">OTOA Conference Hotel Reservation</div>
                    We are requesting all OTOA
                    @can('staff')
                    staff
                    @elsecan('conference-instructor')
                    conference instructors
                    @else
                    VIPs
                    @endif
                    to let us know their hotel preference for the upcoming conference.
                    Please visit the <a class="font-semibold text-otgold" href="{{ route('dashboard.staff.conferences.hotelRequest', $conference) }}">Hotel Reservation</a> page.
                </div>
            </div>
            @endif
            @endforeach
            @endcan



            @can('general-staff')
            @if(!auth()->user()->profile->emergency_name)
            <div class="flex gap-6 items-center mb-6 text-semibold bg-otgold-100 border border-otgold rounded-xl p-6">
                <x-icons.warning class="w-10 h-10 text-otgold" />
                <div class="flex-1">
                    You have not completed your staff profile.
                    Please go to the <a class="font-semibold text-otgold" href="{{ route('dashboard.profile') }}">My Profile</a> page and fill out the fields in the <span class="font-semibold">Staff Related Information</span> section.
                </div>
            </div>
            @endif
            @endcan



            @can('conference-instructor')
            @if($instructorCoursesWarning->isNotEmpty())
            <div class="flex gap-6 items-center mb-6 text-semibold bg-otgold-100 border border-otgold rounded-xl p-6">
                <x-icons.warning class="w-10 h-10 text-otgold" />
                <div class="flex-1">
                    <p>The follow conferece courses that you are teaching are in need of a course description or student requirements:</p>
                    <ul class="list-disc mt-2">
                        @foreach($instructorCoursesWarning as $course)
                        <li class="ml-8"><a class="font-semibold" href="{{ route('dashboard.staff.courses.edit', [$course->conference, $course]) }}">{{ $course->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @endcan






            {{-- ORGANIZATION ADMIN --}}

            @can('organization-admin')
            <div class="text-center">
                You are an Organization Admin for
            </div>
            <div class="font-medium text-2xl lg:text-4xl mb-6 text-center">
                {{ $organization->name }}
            </div>
            <div class="mb-4 flex justify-center">
                @include('site.dashboard.organization.organization-chooser')
            </div>
            <div class="flex flex-col gap-4 mb-6">
                <div class="flex items-center gap-4 border border-otgold bg-otgold-100 p-4">
                    <a href="{{ route('dashboard.organization.users') }}" class="bg-otgold-100">
                        <x-icons.users class="w-12 h-12 text-otgold" />
                    </a>
                    <a href="{{ route('dashboard.organization.users') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            {{ $organization_users->count() }} User{{ $organization_users->count() > 1 ? 's' : '' }}
                        </div>
                        <div class="text-lg leading-tight">
                            In your organization
                        </div>
                    </a>
                    <div>
                        <x-button-link-site type="small" href="{{ route('dashboard.organization.user-create') }}">
                            Add User
                        </x-button-link-site>
                    </div>
                </div>

                <div class="flex items-center gap-4 border border-otgold bg-otgold-100 p-4">
                    <a href="{{ route('dashboard.organization.trainings.index') }}" class="bg-otgold-100">
                        <x-icons.whiteboard class="w-12 h-12 text-otgold" />
                    </a>
                    <a href="{{ route('dashboard.organization.trainings.index') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            Advanced Training
                        </div>
                        <div class="text-lg leading-tight">
                            See what Advanced Training courses members of your organization are taking
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-4 border border-otgold bg-otgold-100 p-4">
                    <a href="{{ route('dashboard.organization.conferences.index') }}" class="bg-otgold-100">
                        <x-icons.conference class="w-12 h-12 text-otgold" />
                    </a>
                    <a href="{{ route('dashboard.organization.conferences.index') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            Conference Training
                        </div>
                        <div class="text-lg leading-tight">
                            See what conference training courses members of your organization are attending
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-4 border border-otblue bg-otblue-100 p-4">
                    <a href="{{ route('trainings') }}" class="bg-otblue-100">
                        <x-icons.clipboard class="w-12 h-12 text-otblue" />
                    </a>
                    <a href="{{ route('trainings') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            Advanced Training Registration
                        </div>
                        <div class="text-lg leading-tight">
                            Register members of your organization for our Advanced Training courses
                        </div>
                    </a>
                </div>
                <div class="flex items-center gap-4 border border-otblue bg-otblue-100 p-4">
                    <a href="{{ route('conferences') }}" class="bg-otblue-100">
                        <x-icons.clipboard class="w-12 h-12 text-otblue" />
                    </a>
                    <a href="{{ route('conferences') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            Conference Registration
                        </div>
                        <div class="text-lg leading-tight">
                            Register members of your organization for our annual conference
                        </div>
                    </a>
                </div>
            </div>
            @endcan


            {{-- VENDOR --}}
            @can('vendor')
            <div class="mb-8">
                @if(!auth()->user()->organization)
                <div class="text-center text-xl max-w-lg mx-auto mb-6">
                    <div>
                        <span class="font-medium">{{ auth()->user()->profile->organization_name}}</span>
                        is not currently in our vendor company database.
                        You will be notified by a member of the OTOA Conference Vendor Show team.
                    </div>
                </div>
                @else

                <div class="text-center">
                    You are a Vendor Company Admin for
                </div>
                <div class="font-medium text-2xl lg:text-4xl mb-6 text-center">
                    {{ auth()->user()->organization->name }}
                </div>

                <div class="flex items-center gap-4 border border-otgold bg-otgold-100 p-4 mb-4">
                    <a href="{{ route('dashboard.company.edit') }}" class="bg-otgold-100">
                        <x-icons.building class="w-12 h-12 text-otgold" />
                    </a>
                    <a href="{{ route('dashboard.company.edit') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            Company Profile
                        </div>
                        <div class="text-lg leading-tight">
                            Edit your company profile and change your logo
                        </div>
                    </a>
                </div>

                @if(auth()->user()->organization->vendorRegistrationSubmissions->where('conference.start_date', '>', now())->isEmpty())


                <div class="flex items-center gap-4 border border-otblue bg-otblue-100 p-4 mb-4">
                    <a href="{{ route('exhibitionRegistration', 'tactical-operations-and-public-safety-conference') }}" class="bg-otblue-100">
                        <x-icons.clipboard class="w-12 h-12 text-otblue" />
                    </a>
                    <a href="{{ route('exhibitionRegistration', 'tactical-operations-and-public-safety-conference') }}" class="flex-1">
                        <div class="font-medium text-2xl leading-tight">
                            Register for Vendor Show
                        </div>
                        <div class="text-lg leading-tight">
                            Your company is not registered for the next conference.
                        </div>
                    </a>
                </div>

                <div class="mb-4 text-center hidden">
                    <div class="text-2xl mb-4">Your company is not registered for the next conference.</div>
                    <div>
                        <x-button-link-site href="{{ route('exhibitionRegistration', 'tactical-operations-and-public-safety-conference') }}" class="text-xl">Vendor Exhibition Registration</x-button-link-site>
                    </div>
                    <div class="mt-2">
                        <x-a href="{{ route('conference.sponsorships', 'tactical-operations-and-public-safety-conference') }}">Booth Options &amp; Sponsorships</x-a>
                    </div>
                </div>
                @else

                <div class="flex gap-6 items-center mb-4 text-semibold bg-otblue-100 border border-otblue p-6">
                    <div class="flex-1">
                        @foreach(auth()->user()->organization->vendorRegistrationSubmissions->where('conference.start_date', '>', now()) as $submission)
                        <div>
                            <div class="font-medium text-2xl">Vendor Exhibition Registration</div>
                            Your company is registered to be a vendor at the
                            <x-a href="{{ route('conference', $submission->conference) }}">{{ $submission->conference->name }}</x-a>.
                            You have until {{ $submission->conference->vendor_end_date->format('F j, Y') }} to <x-a href="{{ route('dashboard.vendor-registrations.edit', $submission) }}">edit your company vendor registration</x-a> if needed.
                            <div class="font-medium text-xl mt-4">Your Registration Status</div>
                            <table>
                                <tr>
                                    <td class="pr-2 align-top text-center">
                                        <i class="fa-solid {{ $submission->public ? 'fa-check text-green-600' : 'fa-xmark text-red-700' }}"></i>
                                    </td>
                                    <td class="font-medium text-right pr-2 align-top">Exposure:</td>
                                    <td>
                                        @if($submission->public)
                                        <div>
                                            Your company,
                                            <x-a href="{{ route('conference.vendor', [$submission->conference, $submission]) }}">{{ $submission->organization->name }}</x-a>,
                                            is displayed on the
                                            <x-a href="{{ route('conference.vendors', $submission->conference) }}">Vendors</x-a>
                                            page.

                                        </div>
                                        @else
                                        <div>
                                            Your registration has not been reviewed yet. Please check back shortly.
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @if($submission->live_fire == 'Yes')
                                <tr>
                                    <td class="pr-2 align-top text-center">
                                        <i class="fa-solid {{ $submission->liveFireSubmission ? 'fa-check text-green-600' : 'fa-xmark text-red-700' }}"></i>
                                    </td>
                                    <td class="font-medium text-right pr-2 align-top">Live Fire:</td>
                                    <td>
                                        @if($submission->liveFireSubmission)
                                        <div>
                                            You have submitted your live fire information.
                                        </div>
                                        @else
                                        <div>
                                            <strong>Attention!!</strong> You are registered for Live Fire. Please fill out <x-a href="{{ route('dashboard.vendor-registrations.live-fire', $submission) }}">this form</x-a>.
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if($submission->advertising_email)
                                <tr>
                                    <td class="pr-2 align-top text-center">
                                        <i class="fa-solid {{ $submission->advertising ? 'fa-check text-green-600' : 'fa-xmark text-red-700' }}"></i>
                                    </td>
                                    <td class="font-medium text-right pr-2 align-top">Advertising:</td>
                                    <td>
                                        @if($submission->advertising)
                                        <div>
                                            Your ad stuff has been received.
                                        </div>
                                        @else
                                        <div>
                                            You have not submitted your ad stuff yet.
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="pr-2 align-top text-center">
                                        <i class="fa-solid {{ $submission->paid ? 'fa-check text-green-600' : 'fa-xmark text-red-700' }}"></i>
                                    </td>
                                    <td class="font-medium text-right pr-2 align-top">Payment:</td>
                                    <td>
                                        @if($submission->paid)
                                        <div>
                                            Payment received.
                                        </div>
                                        @else
                                        <div>
                                            Payment due by June 1st, 2023.
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @if(!$submission->organization->description)
                                <tr>
                                    <td class="pr-2 align-top text-center">
                                        <i class="fa-solid fa-xmark text-red-700"></i>
                                    </td>
                                    <td class="font-medium text-right pr-2 align-top">Profile:</td>
                                    <td>
                                        <div>
                                            Please fill out your description on the <x-a href="{{ route('dashboard.company.edit') }}">My Company</x-a> page.
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($submission->barter)
                                <tr>
                                    <td class="pr-2 align-top text-center">
                                        <i class="fa-solid {{ $submission->barter->completed_at ? 'fa-check text-green-600' : 'fa-xmark text-red-700' }}"></i>
                                    </td>
                                    <td class="font-medium text-right pr-2 align-top">Barter:</td>
                                    <td>
                                        @if($submission->barter->completed_at)
                                        <div>
                                            Barter form completed.
                                        </div>
                                        @else
                                        <div>
                                            Please complete the form below.
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </table>

                            @if($submission->barter)
                            @if(!$submission->barter->completed_at)
                            <div class="font-medium text-2xl mt-4">Barter Information</div>
                            <div>
                                <p class="mb-3">
                                    Your company has been approved for consideration to trade / barter for exhibition space at the OTOA Conference Vendor Show.
                                    Please complete this form and a member of the OTOA staff will contact you.
                                </p>
                                <p class="font-medium text-lg">Provide the following details:</p>
                                <ul class="mb-3 list-disc ml-10">
                                    <li>Full description of item(s)</li>
                                    <li>Value</li>
                                    <li>Firearms - Provide the Make, Model, and Caliber for each</li>
                                </ul>
                                <p class="mb-3 italic">* All trade / barter requests are subject to review and pending approval.</p>


                                <form method="POST" id="main-form" action="{{ route('dashboard.vendor-registrations.barter', [$submission, $submission->barter]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-textarea name="comments" rows="5">{{ $submission->barter->comments }}</x-textarea>
                                    <x-button-site class="mt-3">Submit Barter Information</x-button-site>
                                </form>
                            </div>
                            @endif
                            @endif

                        </div>
                        @endforeach
                    </div>
                </div>

                @endif
                @endif
            </div>
            @endcan


            @if(auth()->user()->events->where('start_date', '>=', now())->isNotEmpty())
            <x-info-h class="text-center">Upcoming events you are hosting</x-info-h>
            <div class="border-t border-otgray mb-10 bg-otgray-50">
                @foreach(auth()->user()->events->where('start_date', '>=', now()) as $event)
                <a href="{{ route('dashboard.events.show', $event) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $event->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $event->start_date->format('m/d/Y H:i') }} -
                                    {{ $event->end_date->format('H:i') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $event->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="text-4xl font-medium">
                                {{ $event->eventAttendees->count() }}
                                <span class="text-xs">/ {{ $event->capacity }}</span>
                            </div>
                            <div class="flex-1 text-sm leading-tight">
                                <div>Member{{ $event->eventAttendees->count() > 1 ? 's' : '' }}</div>
                                <div>Registered</div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif


            @if(auth()->user()->eventAttendees->where('event.start_date', '>=', now())->isNotEmpty())
            <x-info-h class="text-center">Upcoming events you are attending</x-info-h>
            <div class="border-t border-otgray mb-10 bg-otgray-50">
                @foreach(auth()->user()->eventAttendees->where('event.start_date', '>=', now()) as $attendee)
                <a href="{{ route('events.show', $attendee->event) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $attendee->event->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $attendee->event->start_date->format('m/d/Y H:i') }} -
                                    {{ $attendee->event->end_date->format('H:i') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $attendee->event->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="font-medium">
                            <div>{{ $attendee->event->venue ? $attendee->event->venue->name : ''}}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif



            @can('staff-instructor')
            <x-info-h class="text-center">Upcoming Advanced Training courses you are scheduled to teach</x-info-h>

            @if($instructorTrainingCourses->isEmpty())
            <div class="text-center text-red-700 font-light mb-2">No upcoming courses assigned</div>
            @else
            <div class="border-t border-otgray mb-2 bg-otgray-50">
                @foreach($instructorTrainingCourses as $course)
                <a href="{{ route('dashboard.staff.trainingCourses.show', $course) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $course->training->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $course->start_date->format('m/d/Y') }} -
                                    {{ $course->end_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $course->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="text-4xl font-medium">
                                {{ $course->attendees->count() }}
                                <span class="text-xs">/ {{ $course->capacity }}</span>
                            </div>
                            <div class="flex-1 text-sm leading-tight">
                                <div>Member{{ $course->attendees->count() > 1 ? 's' : '' }}</div>
                                <div>Registered</div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            <div class="text-center mb-10">
                <x-a class="text-sm" href="{{ route('dashboard.staff.trainings.index') }}">
                    View all Advanced Training you are teaching
                </x-a>
            </div>
            @endcan


            @can('conference-instructor')
            <x-info-h class="text-center">
                Upcoming Conferences that you are teaching at
            </x-info-h>

            @if($instructorConferences->isEmpty())
            <div class="text-center text-red-700 font-light mb-2">No upcoming conferences assigned</div>
            @else
            <div class="border-t border-otgray mb-2 bg-otgray-50">
                @foreach($instructorConferences as $conference)
                <a href="{{ route('dashboard.staff.conferences.show', $conference) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $conference->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $conference->start_date->format('m/d/Y') }} -
                                    {{ $conference->end_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $conference->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="text-4xl font-medium">{{ $conference->courses->where('user_id', auth()->user()->id)->count() + $conference->sub_instructor_count }}</div>
                            <div class="flex-1 text-sm leading-tight">
                                <div>Course{{ $conference->courses->where('user_id', auth()->user()->id)->count() + $conference->sub_instructor_count > 1 ? 's' : '' }}</div>
                                <div>Teaching</div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
            <div class="text-center mb-10">
                <x-a class="text-sm" href="{{ route('dashboard.staff.conferences.index') }}">
                    View all Conferences you are teaching
                </x-a>
            </div>
            @endcan




            @can('customer')
            @if($trainingCourses->isEmpty() && $conferenceAttendees->isEmpty())
            <div class="hidden text-center text-xl max-w-md mx-auto">
                <div>
                    You are <strong>NOT</strong> registered to attend any upcoming courses as a student.
                </div>
                <div class="mt-4">
                    Check out the <x-a class="" href="{{ route('trainings') }}">Advanced Training</x-a> page to register for an upcoming course.
                </div>
                <div class="mt-4">
                    @foreach($activeConferences as $conference)
                    <x-a href="{{ route('conference', $conference) }}">
                        {{ $conference->name }}
                    </x-a>
                    course offering and online registration is coming soon.
                    @endforeach
                </div>
            </div>
            @endif
            @endcan




            @canany(['customer', 'general-staff'])
            <x-info-h class="text-center">Upcoming Advanced Training courses you are registered for</x-info-h>

            @if($trainingCourseAttendees->isEmpty())
            <div class="text-center text-red-700 font-light mb-2">No upcoming courses registered</div>
            @else
            <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
                @foreach($trainingCourseAttendees as $attendee)
                <a href="{{ route('dashboard.trainings.show', $attendee) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $attendee->trainingCourse->training->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                                    {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $attendee->trainingCourse->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="font-medium">
                            <div>{{ $attendee->trainingCourse->venue ? $attendee->trainingCourse->venue->name : ''}}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
            <div class="text-center mb-10">
                <x-a class="text-sm" href="{{ route('dashboard.trainings.index') }}">
                    View all Advanced Training you are registered for
                </x-a>
            </div>
            @endcanany



            @canany(['customer', 'general-staff'])
            <x-info-h class="text-center">
                Upcoming Conferences that you are registered for
            </x-info-h>
            @if($conferenceAttendees->isEmpty())
            <div class="text-center text-red-700 font-light mb-2">No upcoming conferences registered</div>
            @else
            <div class="border-t border-otgray mb-2 bg-otgray-50">
                @foreach($conferenceAttendees as $attendee)
                <a href="{{ route('dashboard.conferences.show', $attendee) }}" class="block border-b border-otgray py-4 px-4">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $attendee->conference->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $attendee->conference->start_date->format('m/d/Y') }} -
                                    {{ $attendee->conference->end_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $attendee->conference->start_date->diffForHumans() }}
                                </div>
                            </div>
                            @if($attendee->paid)
                            <div class="text-xs">
                                Your invoice has been paid
                            </div>
                            @else

                            @if($attendee->name)
                            <div class="text-sm mt-2">
                                Your invoice will be sent to <span class="font-medium">{{ $attendee->name }}</span> at
                                <span class="font-medium">{{ $attendee->email }}</span>
                            </div>
                            <div class="text-xs">
                                If you would like it sent to someone else please contact us at office@otoa.org
                            </div>
                            @endif
                            @endif
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="text-4xl font-medium">{{ $attendee->courseAttendees->count() }}</div>
                            <div class="flex-1 text-sm leading-tight">
                                <div>Course{{ $attendee->courseAttendees->count() > 1 ? 's' : '' }}</div>
                                <div>Attending</div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
            <div class="text-center mb-10">
                <x-a class="text-sm" href="{{ route('dashboard.conferences.index') }}">
                    View all Conferences you are registered for
                </x-a>
            </div>
            @endcanany


        </div>


        <div class="lg:w-48 bg-otgray-100">
            @canany(['customer', 'general-staff'])
            <div class="">
                <h2 class="text-center font-medium leading-tight bg-otgray-300 px-6 py-2">Membership Status</h2>
                <div class="text-center p-6">
                    @if (auth()->user()->subscribed('default'))
                    <div class="font-medium text-2xl">
                        Active
                    </div>
                    {{-- <div class="text-xs">
                        Until
                    </div>
                    <div class="text-sm font-medium">
                        {{ \Carbon\Carbon::createFromTimeStamp(auth()->user()->subscription('default')->asStripeSubscription()->current_period_end)->format('F jS, Y') }}
                    </div>
                    <div class="mt-6 text-lg">
                        <x-a href="{{ route('billing-portal') }}">Billing Portal</x-a>
                    </div> --}}
                    @else
                    <div>
                        <div class="font-medium text-xl">You are <strong>NOT</strong> a member</div>
                        <div class="font-bold text-xl text-otgold"><a href="{{ route('dashboard.subscribe') }}">Join Now</a></div>
                    </div>
                    @endif
                    {{-- <div class="mt-2">
                        <x-a href="{{ route('dashboard.membership-benefits') }}" class="text-sm">Membership Benefits</x-a>
                    </div> --}}
                </div>
            </div>
            @endcanany

            <div class="">
                <h2 class="text-center font-medium leading-tight bg-otgray-300 px-6 py-2">My Role(s)</h2>
                <div class="text-center px-6 py-4">
                    @if(!empty(auth()->user()->getRoleNames()))
                    @foreach(auth()->user()->getRoleNames() as $v)
                    @php
                    $classes = 'bg-otgold text-white';
                    if($v == 'Admin') {$classes = 'bg-otblue text-white';}
                    if($v == 'Super Admin') {$classes = 'bg-black text-white';}
                    if($v == 'Hotel Coordinator') {$classes = 'bg-otblue text-white';}
                    if($v == 'Live Fire Coordinator') {$classes = 'bg-otblue text-white';}
                    if($v == 'Awards Coordinator') {$classes = 'bg-otblue text-white';}
                    if($v == 'Vendor Management') {$classes = 'bg-otblue text-white';}
                    if($v == 'Board of Directors') {$classes = 'bg-otblue text-white';}

                    if($v == 'Organization Admin') {$classes = 'bg-otsteel text-white';}
                    if($v == 'Staff') {$classes = 'bg-red-800 text-white';}
                    if($v == 'Conference Instructor') {$classes = 'bg-red-800 text-white';}
                    if($v == 'Staff Instructor') {$classes = 'bg-red-800 text-white';}
                    if($v == 'Vendor') {$classes = 'bg-green-800 text-white';}
                    if($v == 'VIP') {$classes = 'bg-otblue-400 text-white';}
                    if($v == 'Medic') {$classes = 'bg-pink-400 text-white';}
                    @endphp
                    <div>
                        <div class="px-3 mb-3 leading-tight mx-auto text-sm rounded-full {{ $classes }}">{{ $v }}</div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            @can('vendor')
            <h2 class="text-center font-medium leading-tight bg-otgray-300 px-6 py-2">For Vendors</h2>
            <div class="p-4 text-center">
                <div>For vendor or exhibitor questions, please contact vendor show coordinator</div>
                <div class="font-medium text-xl">Terry Graham</div>
                <div>
                    <x-a href="mailto:terry.graham@otoa.org">terry.graham@otoa.org</x-a>
                </div>
            </div>
            @endcan


            @can('hotel-request-form')

            <h2 class="text-center font-medium leading-tight bg-otgray-300 px-6 py-2">Hotel Reservation</h2>
            <div class="p-4 text-center">
                @foreach($upcomingConferences as $conference)
                @if(auth()->user()->conferenceHotelRequests->where('conference.id', $conference->id)->isNotEmpty())
                You have submitted your hotel reservation request.
                <div class="mt-4">
                    <x-button-link-site href="{{ route('dashboard.staff.conferences.hotel-edit', $conference) }}">Edit Reservation</x-button-link-site>
                </div>
                @endif
                @endforeach
            </div>

            @else

            <h2 class="text-center font-medium leading-tight bg-otgray-300 px-6 py-2">Conference Hotel Booking</h2>
            <div class="p-4 text-center">
                @can('vendor')
                Please visit
                <x-a href="https://book.passkey.com/e/50391033" target="_blank">book.passkey.com</x-a>
                to reserve a room in our block
                <div class="mt-4">
                    <x-button-link-site href="https://book.passkey.com/e/50391033" target="_blank">Book Room</x-button-link-site>
                </div>
                @else
                Please visit
                <x-a href="https://book.passkey.com/e/50439177" target="_blank">book.passkey.com</x-a>
                to reserve a room in our block
                <div class="mt-4">
                    <x-button-link-site href="https://book.passkey.com/e/50439177" target="_blank">Book Room</x-button-link-site>
                </div>
                @endcan
            </div>

            @endcan



        </div>

</x-dashboard.layout>