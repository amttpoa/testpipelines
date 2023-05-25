<div>
    <x-cards.main class="mb-4 flex gap-4">

        <div>
            <x-input name="searchTerm" type="text" placeholder="Search Courses" wire:model="searchTerm" class="mb-3" />
            <div class="flex gap-3">
                <div class="flex-1">
                    <x-select name="sort" :selections="['open' => 'open', 'date' => 'date']" placeholder=" " wire:model="sort" />
                </div>
                <div>
                    <x-button wire:click.prevent="clear">Clear</x-button>
                </div>
            </div>
        </div>
        <div class="columns-2 md:columns-4 gap-3">
            @foreach($tags as $tag)
            <div>
                <label class="flex items-center gap-2 px-1 py-0.5 text-xs"><input value="{{ $tag->name }}" type="checkbox" name="tag[]" wire:model="tag" />{{ $tag->name}}</label>
            </div>
            @endforeach
        </div>

    </x-cards.main>

    <x-cards.plain class="mb-6">

        <form action="{{ route('admin.course-attendees.rosters', $conference) }}" id="main-form" method="POST" class="w-full" target="_blank">
            @csrf
            <div class="overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="">
                            <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                <th class="px-2 py-3" colspan="2"></th>
                                <th class="px-2 py-3">Date</th>
                                <th class="px-2 py-3">Course</th>
                                <th class="px-2 py-3">Instructor</th>
                                <th class="px-2 py-3">Venue</th>
                                <th class="px-2 py-3">Registered</th>
                                <th class="px-2 py-3">Capacity</th>
                                <th class="px-2 py-3">Open</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-ot-steel">

                            @foreach ($courses as $course)
                            <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                <td class="px-2 w-0">
                                    <input type="checkbox" name="course_id[]" wire:model.defer="course_id" value="{{ $course->id }}" />
                                </td>
                                <td class="pr-2 py-1 whitespace-nowrap">
                                    {{ $course->description ? '' : 'D' }}
                                    {{ $course->requirements ? '' : 'R' }}
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    {{ $course->start_date->format('m/d h:i') }}-{{ $course->end_date->format('h:i') }}
                                </td>
                                <td class="px-2 py-1">
                                    <a class="" href="{{ route('admin.courses.show', [$course->conference, $course]) }}">
                                        <div class="font-medium">{{ $course->name }}</div>
                                    </a>
                                    <div class="leading-none">
                                        @foreach($course->courseTags as $tag)
                                        <div class="text-xs inline-block mr-1">{{ $tag->name }}</div>
                                        @endforeach
                                    </div>
                                    @if($course->restricted)
                                    <div class="text-red-700 text-xs font-medium">No Civilians</div>
                                    @endif
                                </td>
                                <td class="px-2 py-1">
                                    @if($course->user)
                                    <a class="flex gap-1 items-center" href="{{ route('admin.users.show', $course->user) }}">
                                        <x-profile-image :profile="$course->user->profile" class="h-10 w-10" />
                                        <div class="font-medium">{{ $course->user->name }}</div>
                                    </a>
                                    @endif
                                </td>
                                <td class="px-2 py-1">
                                    @if($course->venue)
                                    <a class="" href="{{ route('admin.venues.show', $course->venue) }}">
                                        <div class="font-medium">{{ $course->venue->name }}</div>
                                    </a>
                                    @endif
                                    <div class="text-xs">{{ $course->location }}</div>
                                </td>
                                <td class="px-2 py-1 text-center">
                                    <x-a href="{{ route('admin.course-attendees.index', [$course->conference, $course]) }}">
                                        {{ $course->filled }}
                                    </x-a>
                                </td>
                                <td class="px-2 py-1 text-center">
                                    {{ $course->capacity }}
                                </td>
                                <td class="px-2 py-1 text-center">
                                    {{ $course->available }}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        <div class="p-4">
            {{ $courses->links() }}
        </div>
        <div class="px-4 py-3 border-t border-otsteel">
            <label class="inline-flex items-center justify-start">
                <input type="checkbox" value="on" wire:change="checkAll" wire:model="check_all" class="mr-2" />
                select/deselect all
            </label>
        </div>

    </x-cards.plain>

    <div class="flex gap-3 mt-6 ml-6 items-center" x-data="{ item: '' }">
        <div>

        </div>
        <x-select name="item" form="main-form" x-model="item" wire:model="item" :selections="['' => '', 'View Rosters' => 'View Rosters', 'PDF Rosters' => 'PDF Rosters']" />
        <button :disabled="!item" form="main-form" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150">
            Submit
        </button>
    </div>

</div>