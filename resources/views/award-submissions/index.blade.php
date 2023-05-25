<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Award Submissions
        </x-crumbs.holder>
    </x-crumbs.bar>


    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Nominee</th>
                    <th class="px-4 py-3">Award</th>
                    <th class="px-4 py-3">Submitted</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">

                @foreach($awardSubmissions as $submission)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1">
                        <a href="{{ route('admin.award-submissions.show', $submission) }}">
                            {{ $submission->name_candidate }}
                        </a>
                    </td>
                    <td class="px-4 py-1">
                        {{ $submission->award->name }}
                    </td>
                    <td class="px-4 py-1">
                        {{ $submission->created_at->format('m/d/Y H:i') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>


</x-app-layout>