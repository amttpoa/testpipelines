<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.award-submissions.index') }}">Award Submissions</x-crumbs.a>
            {{ $awardSubmission->name_submitter }}
        </x-crumbs.holder>
    </x-crumbs.bar>

    <x-cards.main>
        <div class="font-medium text-3xl mt-4">{{ $awardSubmission->award->name }}</div>
        <div class="text-2xl font-medium mt-4">Nominee</div>
        <div>{{ $awardSubmission->name_candidate }}</div>
        <div>{{ $awardSubmission->agency_candidate }}</div>
        @if($awardSubmission->image)
        <div class="text-2xl font-medium mt-4">Photo of Nominee</div>
        <div>
            <img class="max-h-56" src="{{ Storage::disk('s3')->url('award-submissions/' . $awardSubmission->image) }}" />
        </div>
        @endif
        @if($awardSubmission->logo)
        <div class="text-2xl font-medium mt-4">Agency Logo/Badge</div>
        <div>
            <img class="max-h-56" src="{{ Storage::disk('s3')->url('award-submissions/' . $awardSubmission->logo) }}" />
        </div>
        @endif

        <div class="text-2xl font-medium mt-4">Event</div>
        <div>{!! str_replace(PHP_EOL, '<br>', $awardSubmission->story) !!}</div>
        <div class="text-2xl font-medium mt-4">Video</div>
        <div>{{ $awardSubmission->video }}</div>

        <div class="text-2xl font-medium mt-4">Submitter</div>
        <div>{{ $awardSubmission->name_submitter }}</div>
        <div>{{ $awardSubmission->agency_submitter }}</div>
        <div>{{ $awardSubmission->email_submitter }}</div>
        <div>{{ $awardSubmission->phone_submitter }}</div>
    </x-cards.main>

</x-app-layout>