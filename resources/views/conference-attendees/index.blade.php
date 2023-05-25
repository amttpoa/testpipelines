<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Attendees
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.conference-attendees.export', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" download target="_blank">Export Attendees</a>
            <a href="{{ route('admin.conference-attendees.send-emails', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Send Emails</a>
            <a href="{{ route('admin.conference-attendees.fill-badges', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Fill Badges</a>
            <a href="{{ route('admin.conference-attendees.view-badges', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Badges</a>
            <a href="{{ route('admin.conference-attendees.pdf-badges', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">PDF Badges</a>
        </x-page-menu>
    </x-crumbs.bar>


    <x-cards.main class="mb-6">
        <div class="flex gap-6 items-start">
            <table class="text-xl">
                <tr>
                    <td class="text-right font-medium pr-2">Attendees:</td>
                    <td class="text-right">{{ $conference->conferenceAttendees->count() }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Invoiced:</td>
                    <td class="text-right">{{ $conference->conferenceAttendees->where('invoiced', 1)->count() }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Paid:</td>
                    <td class="text-right">{{ $conference->conferenceAttendees->where('paid', 1)->count() }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Full Comp:</td>
                    <td class="text-right">{{ $conference->conferenceAttendees->where('comp', 1)->count() }}</td>
                </tr>
            </table>
            <table class="text-xl">
                <tr>
                    <td class="text-right font-medium pr-2">Total:</td>
                    <td class="text-right">${{ number_format($conference->conferenceAttendees->sum('total'), 0) }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Invoiced:</td>
                    <td class="text-right">${{ number_format($conference->conferenceAttendees->where('invoiced')->sum('total'), 0) }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Paid:</td>
                    <td class="text-right">${{ number_format($conference->conferenceAttendees->where('paid')->sum('total'), 0) }}</td>
                </tr>
            </table>
            <table class="text-lg">
                @foreach($conference->conferenceAttendees->groupBy('package') as $key => $attendee)
                <tr>
                    <td class="text-right font-medium pr-2">{{ $key }}:</td>
                    <td>{{ $attendee->count() }}</td>
                </tr>
                @endforeach
            </table>

        </div>
    </x-cards.main>


    @livewire('conference-attendee-search', ['conference' => $conference])

</x-app-layout>