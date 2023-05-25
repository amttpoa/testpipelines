<div>

    <div>
        <table class="">
            <thead>
                <tr class="border-b border-black bg-gray-600 text-white divide-x divide-white">
                    <th class="py-1 px-2 text-left">Course</th>
                    <th class="py-1 px-2">Venue</th>
                    <th class="py-1 px-2">Date</th>
                    <th class="py-1 px-2">Start</th>
                    <th class="py-1 px-2">End</th>
                    <th class="py-1 px-2">Hours</th>
                    <th class="py-1 px-2">Capacity</th>
                    <th class="py-1 px-2">Instructor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr class="divide-x divide-black {{ $loop->index % 2 > 0 ? 'bg-gray-100' : '' }}">
                    <td class="py-1 px-2">
                        <a href="{{ route('admin.courses.edit', [$course->conference, $course]) }}">{{ $course->name }}</a>
                    </td>
                    <td class="py-1 px-2">
                        @if($course->venue)
                        <a href="{{ route('admin.venues.edit', $course->venue) }}">{{ $course->venue->name }}</a>
                        @endif
                    </td>
                    <td class="py-1 px-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($course->start_date)->format('F j') }}</td>
                    <td class="py-1 px-2">{{ \Carbon\Carbon::parse($course->start_date)->format('H:i') }}</td>
                    <td class="py-1 px-2">{{ \Carbon\Carbon::parse($course->end_date)->format('H:i') }}</td>
                    <td class="py-1 px-2 text-center">{{ \Carbon\Carbon::parse($course->start_date)->diff(\Carbon\Carbon::parse($course->end_date))->format("%h:%I") }}</td>
                    <td class="py-1 px-2 text-center">{{ $course->capacity }}</td>
                    <td class="py-1 px-2 text-center whitespace-nowrap">{{ $course->instructor ? $course->instructor->name : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="max-w-xl mt-10">
        @if ($success)

        @endif
        <div class="font-medium text-2xl mb-4">Add Course</div>
        <form wire:submit.prevent="formSubmit" action="/contact" method="POST" class="w-full">
            @csrf
            <div class="mb-3">
                <x-label>Course Name</x-label>
                @error('name')
                <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <x-input wire:model="name" class="" type="text" name="name" value="{{ old('name') }}" required />
            </div>

            <div class="flex gap-3">
                <div class="mb-3">
                    <x-label>Date</x-label>
                    <x-input wire:model="start_date" class="" type="date" name="start_date" value="{{ old('start_date') }}" required />
                    @error('start_date')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <x-label>Time Start</x-label>
                    <x-input wire:model="start_time" class="" type="time" name="start_time" value="{{ old('start_time') }}" required />
                    @error('start_time')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <x-label>Time End</x-label>
                    <x-input wire:model="end_time" class="" type="time" name="end_time" value="{{ old('end_time') }}" required />
                    @error('end_time')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <x-label>Capacity</x-label>
                    <x-input wire:model="capacity" type="number" name="capacity" value="{{ old('capacity') }}" required />
                    @error('capacity')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <x-label>Instructor</x-label>
                <x-select wire:model="user_id" :selections="$instructors" class="" placeholder=" " name="user_id" />
                @error('user_id')
                <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <x-label>Description</x-label>
                <x-textarea wire:model="description" rows="5" class="" name="description">{{ old('description') }}</x-textarea>
                @error('description')
                <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-button>Submit</x-button>
            </div>
        </form>
    </div>

</div>