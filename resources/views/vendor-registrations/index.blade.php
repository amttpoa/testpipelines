<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Vendors
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.vendor-registration-submissions.send-emails', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Send Emails</a>
            <a href="{{ route('admin.vendor-registration-submissions.export', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" download>Export Vendors</a>
            <a href="{{ route('admin.vendor-registration-submissions.export', [$conference, 'type' => 'attendees']) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" download>Export Representatives</a>
            <a href="{{ route('admin.vendor-registration-submissions.export', [$conference, 'view' => 'web']) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Vendors</a>
            <a href="{{ route('admin.vendor-registration-submissions.export', [$conference, 'view' => 'web', 'type' => 'attendees']) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Representatives</a>
            <a href="{{ route('admin.vendor-registration-submissions.fill-badges', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Fill Badges</a>
            <a href="{{ route('admin.vendor-registration-submissions.view-badges', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">View Badges</a>
            <a href="{{ route('admin.vendor-registration-submissions.pdf-badges', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank">PDF Badges</a>
        </x-page-menu>
    </x-crumbs.bar>

    <x-cards.main class="mb-6">
        <div class="flex gap-6 items-start">
            <table class="text-xl">
                <tr>
                    <td class="text-right font-medium pr-2">Vendors:</td>
                    <td class="text-right">{{ $submissions->count() }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Public:</td>
                    <td class="text-right">{{ $submissions->where('public')->count() }}</td>
                </tr>
            </table>
            <table class="text-xl">
                <tr>
                    <td class="text-right font-medium pr-2">Total:</td>
                    <td class="text-right">${{ number_format($submissions->sum('total'), 0) }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Paid:</td>
                    <td class="text-right">${{ number_format($submissions->where('paid')->sum('total'), 0) }}</td>
                </tr>
            </table>
            <table class="text-xl">
                <tr>
                    <td class="text-right font-medium pr-2">Lunches:</td>
                    <td class="text-right">{{ $submissions->sum('lunch_qty') }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Tables:</td>
                    <td class="text-right">{{ $submissions->sum('tables_qty') }}</td>
                </tr>
            </table>
            <table class="text-xl">
                <tr>
                    <td class="text-right font-medium pr-2">Live Fire:</td>
                    <td class="text-right">{{ $submissions->where('live_fire', 'Yes')->count() }}</td>
                </tr>
                <tr>
                    <td class="text-right font-medium pr-2">Total Reps:</td>
                    <td class="text-right">{{ $attendees->count() }}</td>
                </tr>
            </table>
        </div>
        <div class="flex gap-6 items-start mt-6">
            <table class="text-lg">
                <tr>
                    <td colspan="2" class="text-center">Sponsorships</td>
                </tr>
                @foreach($submissions->groupBy('sponsorship') as $key => $submission)
                <tr>
                    <td class="text-right font-medium pr-2">{{ $key }}:</td>
                    <td>{{ $submission->count() }}</td>
                </tr>
                @endforeach
            </table>
            <table class="text-lg hidden">
                <tr>
                    <td colspan="2" class="text-center">Tables</td>
                </tr>
                @foreach($submissions->groupBy('tables') as $key => $submission)
                <tr>
                    <td class="text-right font-medium pr-2">{{ $key }}:</td>
                    <td>{{ $submission->count() }}</td>
                </tr>
                @endforeach
            </table>
            <table class="text-lg">
                <tr>
                    <td colspan="2" class="text-center">Power</td>
                </tr>
                @foreach($submissions->groupBy('power') as $key => $submission)
                @if($key)
                <tr>
                    <td class="text-right font-medium pr-2">{{ $key }}:</td>
                    <td>{{ $submission->count() }}</td>
                </tr>
                @endif
                @endforeach
            </table>
            <table class="text-lg">
                <tr>
                    <td colspan="2" class="text-center">TV</td>
                </tr>
                @foreach($submissions->groupBy('tv') as $key => $submission)
                @if($key)
                <tr>
                    <td class="text-right font-medium pr-2">{{ $key }}:</td>
                    <td>{{ $submission->count() }}</td>
                </tr>
                @endif
                @endforeach
            </table>
            <table class="text-lg">
                <tr>
                    <td colspan="2" class="text-center">Internet</td>
                </tr>
                @foreach($submissions->groupBy('internet') as $key => $submission)
                @if($key)
                <tr>
                    <td class="text-right font-medium pr-2">{{ $key }}:</td>
                    <td>{{ $submission->count() }}</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </x-cards.main>

    @livewire('conference-vendor-search', ['conference' => $conference])


</x-app-layout>