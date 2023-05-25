<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-hotel-requests.index', $conference) }}">Hotel Requests</x-crumbs.a>
            Edit Hotel Request
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.conference-hotel-requests.destroy',  [$conference, $conferenceHotelRequest]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <div class="lg:flex lg:gap-6">
        <div class="lg:flex-1">

            @if($conferenceHotelRequest->user)
            <x-cards.user :user="$conferenceHotelRequest->user" class="mb-6" />
            @endif

            <x-cards.main>
                <x-form-errors />


                <form method="POST" id="main-form" action="{{ route('admin.conference-hotel-requests.update', [$conference, $conferenceHotelRequest]) }}">
                    @csrf
                    @method('PATCH')

                    <div class="flex gap-3">
                        <x-fields.input-text label="Room Type" name="room_type" value="{{ $conferenceHotelRequest->room_type }}" class="mb-3" />
                        <x-fields.input-text label="Roommate" name="roommate" value="{{ $conferenceHotelRequest->roommate }}" class="mb-3" />
                        <x-fields.input-text label="Room" name="room" value="{{ $conferenceHotelRequest->room }}" class="mb-3" />
                    </div>
                    <div class="flex gap-3">
                        <x-fields.input-text type="date" label="Check-in" name="start_date" value="{{ $conferenceHotelRequest->start_date ? $conferenceHotelRequest->start_date->toDateString() : '' }}" class="mb-3" />
                        <x-fields.input-text type="date" label="Check-out" name="end_date" value="{{ $conferenceHotelRequest->end_date ? $conferenceHotelRequest->end_date->toDateString() : '' }}" class="mb-3" />
                    </div>
                    <x-fields.input-text label="Comments" name="comments" value="{!! $conferenceHotelRequest->comments !!}" class="mb-3" />
                </form>
            </x-cards.main>

            <div class="mt-6 ml-6">
                <x-button form="main-form">Save</x-button>
            </div>
        </div>

        <div class="lg:w-1/3">
            <x-cards.main>
                @livewire('notes', ['subject_type' => 'App\Models\ConferenceHotelRequest', 'subject_id' => $conferenceHotelRequest->id])
            </x-cards.main>
        </div>

    </div>
</x-app-layout>