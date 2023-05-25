@props(['active'])

@php
$classes = ($active ?? false)
? 'px-6 py-1 inline-flex items-center w-full text-sm font-semibold text-white transition-colors duration-150 hover:opacity-90'
: 'px-6 py-1 inline-flex items-center w-full text-sm font-semibold text-white transition-colors duration-150 hover:opacity-90';
@endphp

<li class="relative ">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>