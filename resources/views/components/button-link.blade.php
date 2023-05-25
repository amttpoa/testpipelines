@props(['type' => ''])

@if($type == 'light')
<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-1.5 shadow-md bg-white border border-otgold rounded-md text-sm text-otgold hover:bg-otgold-50 hover:border-otgold-500 active:bg-otgold-200 focus:outline-none focus:border-otgold-500 focus:ring-0 ring-0 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
@else
<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring-0 ring-0 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
@endif