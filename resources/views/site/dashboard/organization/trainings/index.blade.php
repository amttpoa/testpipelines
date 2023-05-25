<x-dashboard.layout>
    @section("pageTitle")
    Advanced Training
    @endSection

    <div class="lg:flex lg:gap-3 lg:flex-1">
        <x-breadcrumbs.holder class="flex-1">
            <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
            <x-breadcrumbs.arrow />
            Advanced Training
        </x-breadcrumbs.holder>
        <div>
            @include('site.dashboard.organization.organization-chooser')
        </div>
    </div>

    <x-info-h>Advanced training that members of your organization are attending</x-info-h>

    @if($organization_calendar->isEmpty())
    <div class="text-center text-red-700">
        No advanced training for members in your organization
    </div>
    <div class="mt-4">
        Check out the <x-a href="{{ route('trainings') }}">Advanced Training</x-a> page to register for an upcoming course.
    </div>
    @else
    <div class="border-t border-otgray">
        @foreach ($organization_calendar as $attendee)
        <div class="border-b border-otgray py-4 lg:px-4 lg:items-center grid gap-3 grid-cols-2 lg:grid-cols-5">
            <div class="col-span-2">
                <a class="mb-3 flex gap-3 items-center" href="{{ route('dashboard.organization.trainings.attendee', [$attendee->trainingCourse, $attendee]) }}">
                    <div class="w-16">
                        <x-profile-image class="w-16 h-16" :profile="$attendee->user->profile" />
                    </div>
                    <div class="flex-1 text-ellipsis overflow-hidden">
                        <div class="font-medium text-lg">{{ $attendee->user->name }}</div>
                        <div class="text-otsteel text-sm text-ellipsis overflow-hidden">{{ $attendee->user->email }}</div>
                    </div>
                </a>
                <a href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">
                    <div class="font-medium text-xl">{{ $attendee->trainingCourse->training->name }}</div>
                    <div class="font-medium">
                        {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} -
                        {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                        <span class=" ml-3 text-otsteel text-sm">
                            {{ $attendee->trainingCourse->start_date->diffForHumans() }}
                        </span>
                    </div>
                </a>
                <a class="hidden" href="{{ route('trainingCourse', [$attendee->trainingCourse->training, $attendee->trainingCourse]) }}">
                    <div class="font-medium text-xl">{{ $attendee->trainingCourse->training->name }}</div>
                    <div class="font-medium text-sm">{{ $attendee->trainingCourse->venue->name }}</div>
                    <div class="text-otsteel text-sm">
                        {{ $attendee->trainingCourse->venue->city }},
                        {{ $attendee->trainingCourse->venue->state }}
                    </div>
                </a>
            </div>

            <div class="text-sm">
                <div>
                    @if($attendee->checked_in)
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                        <i class="fa-solid fa-check w-5 text-center"></i> Checked In
                    </div>
                    @else
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
                        <i class="fa-solid fa-x w-5 text-center"></i> Not Checked In
                    </div>
                    @endif
                </div>
            </div>
            <div class="text-sm">
                <div class="">
                    @if($attendee->completed)
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                        <i class="fa-solid fa-check w-5 text-center"></i> Completed
                    </div>
                    @else
                    <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
                        <i class="fa-solid fa-x w-5 text-center"></i> Not Completed
                    </div>
                    @endif
                </div>

            </div>
            <div class="col-span-2 lg:col-span-1">
                <div class="font-medium">
                    @if($attendee->completed)

                    @if($attendee->surveyConferenceCourseSubmission)
                    <div class="text-otgray">
                        Survey Complete
                    </div>
                    <x-a href="{{ route('dashboard.trainingCertificate', $attendee) }}">
                        Download Certificate
                    </x-a>
                    @else
                    <div class="leading-tight text-red-800">
                        Inform Member to Complete Survey
                    </div>
                    <div class="text-otgray text-xs font-light">
                        To Download Certificate
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
        @endforeach
    </div>
    @endif


</x-dashboard.layout>