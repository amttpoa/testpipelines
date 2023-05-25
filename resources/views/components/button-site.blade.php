@props(['type' => ''])

@if($type == 'light')
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2 shadow-md bg-otgold-50 border border-otgold text-sm text-otgold font-medium hover:bg-otgold-100 active:bg-otgold-100 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
@else
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-700 active:bg-otgold-600 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
@endif