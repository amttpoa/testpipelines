@props(['active'])

@php
$classes = ($active ?? false)
? 'px-5 py-3 inline-flex items-center w-full text-sm font-semibold text-white transition-colors duration-150 hover:opacity-90 bg-otblue-700'
: 'px-5 py-3 inline-flex items-center w-full text-sm font-semibold text-white transition-colors duration-150 hover:opacity-90 bg-otblue-900';
@endphp

<li class="relative ">
    {{-- @if($active)
    <span class="absolute inset-y-0 left-0 w-1 bg-cdblue rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif --}}
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>