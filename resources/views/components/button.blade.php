@props(['type' => ''])

@if($type == 'light')
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-1.5 shadow-md bg-white border border-otgold rounded-md text-sm text-otgold hover:bg-otgold-50 hover:border-otgold-500 active:bg-otgold-200 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
@elseif($type == 'small')
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-0.5 shadow-md bg-otgold border border-otgold rounded-md text-xs text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
@else
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
@endif