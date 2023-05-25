<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.trainings.show', $training) }}">{{ $training->name }}</x-crumbs.a>
            Courses
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.training-courses.create', $training) }}">Create Course</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.plain>


        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Dates</th>
                    <th class="px-4 py-3">Instructor</th>
                    <th class="px-4 py-3">Venue</th>
                    <th class="px-4 py-3 text-center">Registered</th>
                    <th class="px-4 py-3 text-center">Capacity</th>
                    <th class="px-4 py-3 text-center">Edit</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">


                @foreach($courses as $course)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                    <td class="px-4 py-3">
                        <a href="{{ route('admin.training-courses.show', [$training, $course]) }}">
                            {{ $course->start_date->format('m/d/Y') }} -
                            {{ $course->end_date->format('m/d/Y') }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        {{ $course->user ? $course->user->name : '' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $course->venue ? $course->venue->name : '' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        {{ $course->attendees->count() }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        {{ $course->capacity }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.training-courses.edit', [$training, $course]) }}">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>


        <div class="p-4">
            {{ $courses->links() }}
        </div>


    </x-cards.plain>

</x-app-layout>