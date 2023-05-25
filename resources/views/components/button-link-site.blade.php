@props(['type' => ''])

@if($type == 'light')
<a {{ $attributes->merge(['class' => 'inline-flex items-center px-5 py-2 shadow-md bg-white border border-otgold text-sm text-otgold hover:bg-otgold-50 active:bg-otgold-100 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
@elseif($type == 'small')
<a {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 shadow-md bg-otgold border border-otgold text-xs text-white hover:bg-otgold-700 active:bg-otgold-600 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
@else
<a {{ $attributes->merge(['class' => 'inline-flex items-center px-5 py-2 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-700 active:bg-otgold-600 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
@endif