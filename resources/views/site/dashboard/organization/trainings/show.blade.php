<x-dashboard.layout>
    @section("pageTitle")
    {{ $trainingCourse->training->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.organization.trainings.index') }}">Advanced Training</a>
        <x-breadcrumbs.arrow />
        {{ $trainingCourse->training->name }}
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


</x-dashboard.layout>