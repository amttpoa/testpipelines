@props(['tab'])

<div class="p-4 lg:p-6" x-show="tab === '{{ $tab }}'" {{ $attributes }} style="display:none;">
    {{ $slot }}
</div>