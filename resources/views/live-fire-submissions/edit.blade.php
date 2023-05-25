<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.live-fire-submissions.index', $conference) }}">Live Fire Submissions</x-crumbs.a>
            Edit Submission
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.live-fire-submissions.destroy',  [$conference, $liveFireSubmission]) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.live-fire-submissions.update', [$conference, $liveFireSubmission]) }}">
            @csrf
            @method('PATCH')

            <div class="font-medium text-2xl mb-4">
                {{ $liveFireSubmission->vendorRegistrationSubmission->organization->name }}
            </div>

            <x-fields.input-text label="Bringing" name="bringing" value="{!! $liveFireSubmission->bringing !!}" class="mb-3" />
            <x-fields.input-text label="Firearm" name="firearm" value="{{ $liveFireSubmission->firearm }}" class="mb-3" />
            <x-fields.input-text label="Caliber" name="caliber" value="{{ $liveFireSubmission->caliber }}" class="mb-3" />
            <x-fields.input-text label="Share" name="share" value="{{ $liveFireSubmission->share }}" class="mb-3" />
            <x-fields.input-text label="Share With" name="share_with" value="{{ $liveFireSubmission->share_with }}" class="mb-3" />
            <x-fields.input-text label="Description" name="description" value="{!! $liveFireSubmission->description !!}" class="mb-3" />
        </form>
    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>