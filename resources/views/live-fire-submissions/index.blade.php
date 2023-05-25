<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Live Fire Submissions
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.live-fire-submissions.export', $conference) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" download>Export</a>
        </x-page-menu>
    </x-crumbs.bar>

    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Bringing</th>
                    <th class="px-4 py-3">Firearm</th>
                    <th class="px-4 py-3">Caliber</th>
                    <th class="px-4 py-3">Share</th>
                    <th class="px-4 py-3">Description</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($submissions as $submission)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                    <td class="px-4 py-3">
                        <a class="font-medium" href="{{ route('admin.live-fire-submissions.edit', [$conference, $submission] ) }}">{{ $submission->vendorRegistrationSubmission->organization->name }}</a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $submission->bringing }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $submission->firearm }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $submission->caliber }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $submission->share }}
                        @if($submission->share == 'Yes')
                        - {{ $submission->share_with }}
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        {{ $submission->description }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

    </x-cards.plain>

</x-app-layout>