<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            Courses
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.courses.create', [$conference]) }}">Create Course</x-button-link>
        </div>
    </x-crumbs.bar>

    @livewire('conference-course-search', ['conference' => $conference])

</x-app-layout>