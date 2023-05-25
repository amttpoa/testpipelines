<x-dashboard.layout>
    @section("pageTitle")
    {{ $trainingCourseAttendee->user->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.trainings.index') }}">Advanced Training</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.trainings.show', $trainingCourse) }}">{{ $trainingCourse->training->name }}</a>
        <x-breadcrumbs.arrow />
        {{ $trainingCourseAttendee->user->name }}
    </x-breadcrumbs.holder>

    <div class="font-medium text-2xl">
        <a href="{{ route('dashboard.organization.trainings.show', $trainingCourse) }}">{{ $trainingCourse->training->name }}</a>
    </div>
    <div class="lg:flex lg:gap-4 lg:items-center mb-4">
        <div class="text-lg">
            {{ $trainingCourse->start_date->format('m/d/Y') }} -
            {{ $trainingCourse->end_date->format('m/d/Y') }}
        </div>
        <div class="text-otgray text-sm">
            {{ $trainingCourse->start_date->diffForHumans() }}
        </div>
    </div>

    <div class="lg:flex lg:gap-4 lg:items-center mb-8">
        <div class="lg:flex-1">
            <a class="flex gap-3 items-center" href="{{ route('dashboard.organization.user', $trainingCourseAttendee->user) }}">
                <div class="w-16">
                    <x-profile-image class="w-16 h-16" :profile="$trainingCourseAttendee->user->profile" />
                </div>
                <div class="flex-1 text-ellipsis overflow-hidden">
                    <div class="font-medium text-xl">{{ $trainingCourseAttendee->user->name }}</div>
                    <div class="text-otsteel text-sm text-ellipsis overflow-hidden">{{ $trainingCourseAttendee->user->email }}</div>
                </div>
            </a>
        </div>
    </div>

    <a href="{{ route('trainingCourse', [$trainingCourseAttendee->trainingCourse->training, $trainingCourseAttendee->trainingCourse]) }}">
        <div class="font-medium">
            {{ $trainingCourseAttendee->trainingCourse->start_date->format('m/d/Y') }} -
            {{ $trainingCourseAttendee->trainingCourse->end_date->format('m/d/Y') }}
        </div>
        <div class="text-otsteel text-sm">
            {{ $trainingCourseAttendee->trainingCourse->start_date->diffForHumans() }}
        </div>
    </a>

</x-dashboard.layout>