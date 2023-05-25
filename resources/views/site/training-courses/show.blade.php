<x-site-layout>
    @section("pageTitle")
    {{ $trainingCourse->training->name }}
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('trainings') }}">Advanced Training</a></div>
        <div class="text-3xl lg:text-6xl"><a href="{{ route('training', $trainingCourse->training) }}">{{ $trainingCourse->training->name }}</a></div>
    </x-banner>


    @if(!$trainingCourse->visible)
    <div class="bg-otsteel flex-1 flex flex-col">
        <div class="max-w-4xl p-6 sm:px-10 flex-1 w-full bg-white mx-auto font-medium text-center text-2xl">
            This course is not available.
        </div>
    </div>
    @else

    <section class="bg-otsteel border-b py-8 flex-1">

        <div class="max-w-6xl mx-auto bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-6 p-2 text-2xl lg:text-4xl font-bold font-blender">
                Course Details
            </div>
            <div class="p-6 grid lg:grid-cols-4 items-center gap-6">
                <div class="lg:col-span-2">

                    <div class="font-medium text-2xl">
                        <a href="{{ route('training', $trainingCourse->training->slug) }}">
                            {{ $trainingCourse->training->name }}
                        </a>
                    </div>
                    <div class="font-medium text-xl">
                        {{ $trainingCourse->start_date->format('m/d/Y') }}
                        - {{ $trainingCourse->end_date->format('m/d/Y') }}
                    </div>
                    @if($trainingCourse->venue)
                    <div class="mt-4">
                        <a href="{{ route('venue', $trainingCourse->venue->slug) }}" class="font-semibold text-xl text-otgold">{{ $trainingCourse->venue->name }}</a>
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
                <div class="lg:text-center">

                    <div class="font-medium text-sm">Price</div>
                    <div class="text-5xl font-blender font-bold">${{ $trainingCourse->price }}</div>
                    <div class="text-otsteel mt-4">{{ $trainingCourse->attendees->count() }} of {{ $trainingCourse->capacity }} seats taken</div>


                    @if(!$trainingCourse->active && $trainingCourse->active_admin)

                    @if(auth()->check())
                    @if(auth()->user()->can('organization-admin'))
                    <div class="text-lg font-medium">
                        You may register your organization members for this course
                    </div>
                    <div class="mt-4">
                        <x-button-link-site class="text-xl" href="{{ route('trainingCourse.register', [$trainingCourse->training->slug, $trainingCourse]) }}">Register</x-button-link-site>
                    </div>
                    @endif
                    @else
                    <div class="text-lg font-medium">
                        Registration is restricted to organization administrators
                    </div>
                    @endif

                    @elseif(!$trainingCourse->active)
                    <div class="text-lg font-medium">
                        Contact <x-a href="mailto:training@otoa.org">training@otoa.org</x-a> to register for this course
                    </div>
                    @else

                    @if($trainingCourse->attendees->count() >= $trainingCourse->capacity)
                    This course is full
                    <div>
                        <x-a href="{{ route('trainingCourse.register', [$trainingCourse->training, $trainingCourse]) }}">
                            Get on the waitlist
                        </x-a>
                    </div>
                    @else

                    @auth
                    @if(auth()->user()->trainingCourseAttendees->where('training_course_id', $trainingCourse->id)->first() && !auth()->user()->can('organization-admin'))
                    You are registerd for this course
                    @else
                    <div class="mt-4">
                        <x-button-link-site class="text-xl" href="{{ route('trainingCourse.register', [$trainingCourse->training->slug, $trainingCourse]) }}">Register</x-button-link-site>
                    </div>
                    @endif
                    @endauth

                    @guest
                    <div class="mt-4">
                        <x-button-link-site class="text-xl" href="{{ route('trainingCourse.register', [$trainingCourse->training->slug, $trainingCourse]) }}">Register</x-button-link-site>
                    </div>
                    @endguest

                    @endif
                    @endif
                </div>

                @if($trainingCourse->user)
                @if($trainingCourse->users->isNotEmpty())
                <div class="">
                    <a href="{{ route('staffProfile', $trainingCourse->user) }}" class="flex items-center gap-3 mb-2">
                        <x-profile-image class="w-16 h-16" :profile="$trainingCourse->user->profile" />
                        <div class="leading-none">
                            <div class="text-lg font-medium leading-none">{{ $trainingCourse->user->name }}</div>
                            <div class="text-xs text-otsteel">{{ $trainingCourse->user->profile->title }}</div>
                        </div>
                    </a>
                    @foreach($trainingCourse->users as $user)
                    <a href="{{ route('staffProfile', $user) }}" class="flex items-center gap-3 mb-2">
                        <div class="text-center w-16">
                            <x-profile-image class="w-10 h-10 inline" :profile="$user->profile" />
                        </div>
                        <div class="leading-none">
                            <div class="font-medium">{{ $user->name }}</div>
                            <div class="text-xs text-otsteel">{{ $user->profile->title }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center lg:w-40">
                    <a class="" href="{{ route('staffProfile', $trainingCourse->user) }}">
                        <x-profile-image class="w-40 h-40 inline" :profile="$trainingCourse->user->profile" />
                        <div class="text-xl font-medium">{{ $trainingCourse->user->name }}</div>
                    </a>
                </div>
                @endif
                @endif



            </div>
        </div>

        @can('organization-admin')
        @if($trainingCourse->attendees->where('user.organization_id', session()->get('organization_id'))->isNotEmpty())
        <div class="max-w-6xl mx-auto bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-6 p-2 text-2xl lg:text-4xl font-bold font-blender">
                My Organization Attendees
            </div>
            <div class="p-6">

                <div class="md:columns-2 md:gap-2">
                    @foreach($trainingCourse->attendees->where('user.organization_id', session()->get('organization_id')) as $attendee)
                    <div class="break-inside-avoid mb-2">
                        <label class="flex gap-2 items-center px-1 py-1">
                            <x-profile-image class="h-10 w-10" :profile="$attendee->user->profile" />
                            <div class="flex-1">
                                <div class="font-medium">{{ $attendee->user->name }}</div>
                                <div class="text-sm text-otgray">{{ $attendee->user->email }}</div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>


        </div>
        @endif
        @endcan

        <div class="max-w-6xl mx-auto bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-6 p-2 text-2xl lg:text-4xl font-bold font-blender">
                {{ $trainingCourse->training->name }} Description
            </div>
            <div class="p-6">
                <div class="prose max-w-full">
                    {!! $trainingCourse->training->description !!}
                </div>
            </div>
        </div>

    </section>
    @endif

</x-site-layout>