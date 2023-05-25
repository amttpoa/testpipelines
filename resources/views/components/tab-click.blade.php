@props(['tab', 'item' => 'universal_tab'])

<div class="whitespace-nowrap p-2 lg:p-4 text-xs cursor-pointer flex-1 border-r border-b lg:border-0 border-cdblue-50" :class="{ 'bg-white': tab === '{{ $tab }}', '': tab !== '{{ $tab }}' }" @click="tab = '{{ $tab }}'; localStorage.setItem('{{ $item }}', '{{ $tab }}')">
    {{ $slot }}
</div>