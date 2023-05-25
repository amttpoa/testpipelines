<x-dashboard.layout>
    @section("pageTitle")
    Advanced Training
    @endSection

    <x-breadcrumbs.holder>
        Advanced Training
    </x-breadcrumbs.holder>

    <x-info-h class="">Advanced Training courses you are teaching</x-info-h>

    @if($courses->isEmpty())
    <div class="text-red-700 font-light mb-2">No courses assigned</div>
    @else
    <div class="border-t border-otgray mb-2">
        @foreach($courses as $course)
        <a href="{{ route('dashboard.staff.trainingCourses.show', $course) }}" class="block border-b border-otgray py-4 lg:px-4">
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


</x-dashboard.layout>