<x-dashboard.layout>
    @section("pageTitle")
    Conferences
    @endSection

    <x-breadcrumbs.holder>
        Conferences
    </x-breadcrumbs.holder>

    <x-info-h>
        Conferences that you are teaching at
    </x-info-h>

    @if($conferences->isEmpty())
    <div class="">You have not been assigned any conference courses to teach.</div>
    @else

    <div class="border-t border-otgray bg-otgray-50">
        @foreach($conferences as $conference)
        <a href="{{ route('dashboard.staff.conferences.show', $conference) }}" class="block border-b border-otgray py-4 lg:px-4">
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



</x-dashboard.layout>