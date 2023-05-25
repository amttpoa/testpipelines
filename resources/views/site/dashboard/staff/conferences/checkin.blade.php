<x-dashboard.layout>
    @section("pageTitle")
    {{ $conference->name }} Check In
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.conferences.index') }}">Conferences</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.staff.conferences.show', $conference) }}">{{ $conference->name }}</a>
        <x-breadcrumbs.arrow />
        Check In

    </x-breadcrumbs.holder>


    <div class="md:flex md:gap-3">
        <div class="md:flex-1 mb-8">

            <div class="font-medium text-2xl mb-4">
                {{ $conference->name }}
            </div>

            <div>

                @livewire('conference-checkin', ['conference' => $conference])
            </div>

        </div>


    </div>





</x-dashboard.layout>