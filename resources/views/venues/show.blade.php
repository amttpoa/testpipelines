<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.venues.index') }}">Venues</x-crumbs.a>
            {{ $venue->name }}
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.venues.edit', $venue) }}">Edit Venue</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid xl:grid-cols-2 gap-6 mb-6">
        <x-cards.main>
            <div class="font-medium text-2xl">{{ $venue->name }}</div>
            <div class="">{{ $venue->address }}</div>
            <div class="">
                {{ $venue->city }}{{ $venue->city ? ', ' : '' }}
                {{ $venue->state }}
                {{ $venue->zip }}
            </div>
            <div class="">{{ $venue->phone }}</div>
            <div class="mt-3">
                Recommended Hotels: {{ $venue->hotels->count() }}
            </div>
            <div>
                Contact Person:
                @if($venue->user)
                <x-a href="{{ route('admin.users.show', $venue->user) }}">{{ $venue->user->name }}</x-a>
                @else
                NONE
                @endif
            </div>
        </x-cards.main>

        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\Venue', 'subject_id' => $venue->id])
        </x-cards.main>
    </div>

    <div class="mt-6">
        <x-cards.plain>
            <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
                Upcoming Conference Courses
            </div>
            <x-admin.table>
                <thead class="">
                    <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                        <th class="px-4 py-3">Course</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Time</th>
                        <th class="px-4 py-3">Location</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-ot-steel">

                    @foreach ($courses as $course)
                    <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                        <td class="px-4 py-1 font-medium">
                            <a class="" href="{{ route('admin.courses.show', [$course->conference, $course]) }}">
                                {{ $course->name }}
                            </a>
                        </td>
                        <td class="px-4 py-1">
                            {{ $course->start_date->format('m/d/Y') }}
                        </td>
                        <td class="px-4 py-1">
                            {{ $course->start_date->format('H:i') }} -
                            {{ $course->end_date->format('H:i') }}
                        </td>
                        <td class="px-4 py-1">
                            {{ $course->location }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        </x-cards.plain>
    </div>

</x-app-layout>