<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            {{ $training->name }}
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.training-courses.create', $training) }}" type="light">Add Course</x-button-link>
        </div>
        <div>
            <x-button-link href="{{ route('admin.trainings.edit', $training) }}">Edit Training</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.main class="flex gap-4">
        <div>
            <h2 class="mb-4 text-xl font-semibold">{{ $training->name }}</h2>
            <div class="prose max-w-full">
                {!! $training->short_description !!}
            </div>
            <x-a href="{{ route('admin.training-courses.index', $training) }}">
                All Courses
            </x-a>
        </div>
        <div class="text-center">
            <div class="font-medium text-sm">Price</div>
            <div class="font-semibold text-4xl">${{ $training->price }}</div>
            <div class="">{{ $training->days }} days</div>
            <div class="">{{ $training->hours }} hours</div>
        </div>

    </x-cards.main>

    <x-cards.plain class="mt-6">
        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">Dates</th>
                            <th class="px-4 py-3">Instructor</th>
                            <th class="px-4 py-3">Venue</th>
                            <th class="px-4 py-3 text-center">Visible</th>
                            <th class="px-4 py-3 text-center">Active</th>
                            <th class="px-4 py-3 text-center">Admin</th>
                            <th class="px-4 py-3 text-center">Registered</th>
                            <th class="px-4 py-3 text-center">Capacity</th>
                            <th class="px-4 py-3 text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">

                        @foreach($training->courses as $course)
                        <tr class="{{ $course->end_date > now() ? 'font-medium' : 'text-otgray' }} {{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

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
                                @if($course->visible)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($course->active)
                                <i class="fa-solid fa-check"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($course->active_admin)
                                <i class="fa-solid fa-check"></i>
                                @endif
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
                </table>
            </div>
        </div>

    </x-cards.plain>

</x-app-layout>