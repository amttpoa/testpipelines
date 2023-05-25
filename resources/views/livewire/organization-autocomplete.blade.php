<div class="relative">
    <x-label for="organization_name">{{ $label ? $label : 'Organization Name' }}</x-label>

    <div class="relative">
        <x-input type="text" :required="$required" name="organization_name{{ $ext }}" placeholder="{{ $placeholder ? $placeholder : 'Search Organizations...' }}" autocomplete="off" class="placeholder:text-gray-500 placeholder:text-sm" wire:model="query" XXwire:click="reset" wire:keydown.escape="hideDropdown" wire:keydown.tab="hideDropdown" wire:keydown.Arrow-Up="decrementHighlight" wire:keydown.Arrow-Down="incrementHighlight" wire:keydown.enter.prevent="selectAccount" />
        <input type="hidden" name="organization_id{{ $ext }}" id="organization_id{{ $ext }}" wire:model="selectedAccount" value="{{ $organization_id ? $organization_id : '' }}">

        @if ($selectedAccount)
        <a class="absolute cursor-pointer top-1.5 right-2 text-gray-500" wire:click="reset">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>
        @endif
    </div>

    @if(!empty($query) && $selectedAccount == 0 && $showDropdown)
    <div class="absolute z-10 bg-white mt-0 w-full border border-gray-300 rounded-md shadow-lg">
        @if (!empty($organizations))
        @foreach($organizations as $i => $organization)
        <a wire:click="selectAccount({{ $i }})" class="block py-1 px-2 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndex === $i ? 'bg-blue-50' : '' }}">
            <div>{{ $organization->name }}</div>
            <div>{{ $organization->address }}</div>
        </a>
        @endforeach
        @else
        <span class="block py-1 px-2 text-sm">A new organization will be created</span>
        @endif
    </div>
    @endif
</div>