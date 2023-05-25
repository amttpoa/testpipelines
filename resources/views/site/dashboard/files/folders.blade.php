<x-dashboard.layout>
    @section("pageTitle")
    Files
    @endSection

    <x-breadcrumbs.holder>
        Files
    </x-breadcrumbs.holder>

    @if(auth()->user()->can('civilian'))
    <div class="font-medium text-xl">
        Civilians are not allowed to access shared files.
    </div>
    @elseif(!auth()->user()->subscribed())
    <div class="font-medium text-xl">
        You are not a current member.
        Please <x-a href="{{ route('dashboard.subscribe') }}">subscribe</x-a> to a membership plan to access shared files.
    </div>
    @else

    <div class="grid md:grid-cols-2 gap-4">
        @foreach($folders as $folder)
        <a href="{{ route('dashboard.upload-files.index', $folder) }}">
            <div class="border border-otgray-300 rounded-xl p-4 flex items-center gap-3 hover:bg-otgray-50">
                <div class="w-16">
                    @if($folder->restriction == 'Board of Directors Only')
                    <x-icons.folder class="w-16 h-16" color1="a6b0b6" color2="7e8892" />
                    @elseif($folder->restriction == 'Staff Instructors Only')
                    <x-icons.folder class="w-16 h-16" color1="b91c1c" color2="7f1d1d" />
                    @elseif($folder->restriction)
                    <x-icons.folder class="w-16 h-16" color1="335071" color2="293a4e" />
                    @else
                    <x-icons.folder class="w-16 h-16" color1="d49c6a" color2="bb6a3b" />
                    @endif
                </div>
                <div class="flex-1">
                    <div class="font-medium text-xl">{{ $folder->name }}</div>
                    <div class="text-otgray">{{ $folder->description }}</div>
                    <div class="text-sm font-medium">{{ $folder->uploadFiles->count() }} file{{ $folder->uploadFiles->count() == 1 ? '' : 's' }}</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif


</x-dashboard.layout>