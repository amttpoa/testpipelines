<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-attendees.index', $conference) }}">Attendees</x-crumbs.a>
            Send Emails
        </x-crumbs.holder>
    </x-crumbs.bar>

    <div class="lg:flex gap-6">

        <x-cards.main class="flex-1 mb-6">

            <form method="POST" id="main-form" action="{{ route('admin.conference-attendees.send-emails', $conference) }}">
                @csrf

                <div class="mb-3">
                    <x-fields.select label="To" name="to" :selections="$tos" placeholder=" " required />
                </div>

                <x-fields.input-text label="Subject" name="subject" value="" class="mb-3" />

                <div class="mb-3">
                    <x-label>Message</x-label>
                    <x-textarea rows="5" class="addTiny" name="message"></x-textarea>
                </div>

            </form>

        </x-cards.main>

        <x-cards.main class="lg:w-80 mb-6">
            <h2 class="font-medium text-2xl mb-4">Emails Sent</h2>
            <div class="max-h-96 overflow-auto">
                @foreach($sent as $send)
                <div class="text-xs">{{ $send->to }} - {{ $send->sent }} emails</div>
                <div>{{ $send->subject }}</div>
                <div class="text-otgray text-sm mb-2">{{ $send->created_at->format('m/d/Y h:i') }}</div>
                @endforeach
            </div>
        </x-cards.main>


    </div>

    <div class="ml-6">
        <x-button form="main-form">Send Emails</x-button>
    </div>


</x-app-layout>