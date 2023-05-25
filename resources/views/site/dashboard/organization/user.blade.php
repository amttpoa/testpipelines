<x-dashboard.layout>
    @section("pageTitle")
    {!! $user->name !!}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.users') }}">Users</a>
        <x-breadcrumbs.arrow />
        {{ $user->name }}
    </x-breadcrumbs.holder>


    <div class="grid md:grid-cols-2 gap-4">

        <div class="flex gap-6 items-center mb-8">
            <div class="w-40">
                <x-profile-image class="w-40 h-40" :profile="$user->profile" />
            </div>
            <div class="flex-1">
                <div class="text-2xl font-medium">
                    {{ $user->name }}
                </div>
                <div class="font-medium">
                    {{ $user->profile->title }}
                </div>
                <div class="text-otgray">
                    {{ $user->email }}
                </div>
                <div class="text-otgray">
                    {{ $user->profile->phone }}
                </div>
                <div class="mt-3 text-sm">
                    <x-a href="{{ route('dashboard.organization.users.edit', $user) }}">
                        Edit user
                    </x-a>
                </div>
            </div>
        </div>

        <div>
            @if($user->subscribed())
            <div class="font-medium text-xl">
                {{ $user->subscription()->authorize_plan }}
            </div>
            <div class="text-xs mb-2">
                Started on {{ $user->subscription()->created_at->format('m/d/Y') }}
            </div>

            @if($user->subscription()->parent)
            @if($user->subscription()->parent->organization_id == session()->get('organization_id'))
            <form method="POST" action="{{ route('dashboard.organization.users.cancel',  $user) }}" class="mt-4" onsubmit="return confirm('Are you sure you want to remove this user from {{ $user->subscription()->parent->authorize_plan }}?')">
                @csrf
                <x-button-site>Remove from {{ $user->subscription()->parent->authorize_plan }}</x-button-site>
            </form>
            @endif
            @endif

            @else
            <div>
                Not subscribed
            </div>
            @foreach($admin_organization->activeSubscriptions() as $subscription)
            <form method="POST" action="{{ route('dashboard.organization.users.subscribe',  [$user, $subscription]) }}" class="mt-4">
                @csrf
                <x-button-site>Add to {{ $subscription->authorize_plan }}</x-button-site>
            </form>
            @endforeach

            @endif
        </div>

    </div>


    <div class="hidden">
        <div class="text-xl mb-2">
            Advanced Training courses {{ $user->name }} is registered for
        </div>

        @if($trainingCourseAttendees->isEmpty())
        <div class="text-red-800">
            {{ $user->name }} is not registered for any advanced training courses.
        </div>
        @endif

        @foreach($trainingCourseAttendees as $attendee)

        <div class="mb-4">
            <div>
                <div class="p-4 grid lg:grid-cols-3 lg:gap-4 items-center border border-otgray {{ $attendee->trainingCourse->start_date > now() ? 'bg-otgray-50' : 'bg-otgray-200' }}">
                    <div class="">
                        <div class="text-sm text-otgray">
                            @if($attendee->trainingCourse->start_date > now())
                            Upcoming Advanced Training Course
                            @else
                            Completed Training Course
                            @endif
                        </div>
                        <div class="font-medium text-2xl">{{ $attendee->trainingCourse->training->name }}</div>
                        <div>
                            {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                            {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                        </div>
                    </div>
                    <div class="font-medium lg:text-center">
                        <div class="text-3xl hidden">@</div>
                        {{ $attendee->trainingCourse->venue ? $attendee->trainingCourse->venue->name : ''}}
                    </div>

                    <div class="lg:text-right">
                        @if($attendee->completed)

                        <div class="">
                            Course Completed
                        </div>
                        @if($attendee->surveyTrainingCourseSubmission)
                        <x-a href="{{ route('dashboard.trainings.certificate', $attendee) }}">
                            Download Certificate
                        </x-a>
                        @else
                        <div class="text-otgray text-sm">
                            Survey Not Completed
                        </div>
                        @endif

                        @else
                        <div class="text-otgray">
                            Course Not Completed
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <x-info-h>Advanced training that {{ $user->name }} is attending</x-info-h>
    <div class="mb-8">
        @if($user->trainingCourseAttendees->isEmpty())
        <div class="text-red-700">
            No advanced training for {{ $user->name }}
        </div>
        @else
        <div class="border-t border-otgray bg-otgray-50">
            @foreach ($user->trainingCourseAttendees as $attendee)
            <div class="border-b border-otgray py-4 lg:px-4 lg:items-center flex gap-3 flex-col lg:flex-row">
                @if(!$attendee->trainingCourse)
                DELETED COURSE
                @else
                <div class="lg:w-1/3">
                    <a href="{{ route('dashboard.organization.trainings.attendee', [$attendee->trainingCourse, $attendee]) }}">
                        <div class="font-medium text-2xl">{{ $attendee->trainingCourse->training->name }}</div>
                    </a>
                </div>
                <div class="lg:flex-1">
                    <a href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">
                        <div class="font-medium">
                            {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                            {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                        </div>
                        <div class="text-otsteel text-sm">
                            {{ $attendee->trainingCourse->start_date->diffForHumans() }}
                        </div>
                    </a>
                </div>
                <div class="lg:w-1/3">
                    <a href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">

                        <div class="font-medium text-sm">{{ $attendee->trainingCourse->venue->name }}</div>
                        <div class="text-otsteel text-sm">
                            {{ $attendee->trainingCourse->venue->city }},
                            {{ $attendee->trainingCourse->venue->state }}
                        </div>
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>





    <x-info-h>
        Conferences that {{ $user->name }} is attending
    </x-info-h>
    <div>
        @if($user->conferenceAttendees->isEmpty())
        <div class="text-red-700">
            No conference training for {{ $user->name }}
        </div>
        @else
        <div class="border-t border-otgray bg-otgray-50">
            @foreach ($user->conferenceAttendees as $attendee)
            <a href="{{ route('dashboard.organization.conferences.attendee', [$attendee->conference, $attendee]) }}" class="grid lg:grid-cols-5 gap-3 items-center border-b border-otgray py-4 lg:px-4">
                <div class="lg:col-span-2">
                    <div class="font-medium text-xl">
                        {{ $attendee->conference->name}}
                    </div>
                </div>
                <div class="text-xl font-medium">
                    {{ $attendee->courseAttendees->count() }} Course{{ $attendee->courseAttendees->count() == 1 ? '' : 's' }}
                </div>
                <div class="text-xs lg:col-span-2">
                    @foreach($attendee->courseAttendees as $courseAttendee)
                    <div>{{ $courseAttendee->course ? $courseAttendee->course->name : '' }}</div>
                    @endforeach
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

</x-dashboard.layout>