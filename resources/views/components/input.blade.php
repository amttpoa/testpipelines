@props(['disabled' => false, 'required' => false, 'type' => 'text'])

<input type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} {!! $attributes->merge(['class' => 'block w-full py-1 px-2 rounded-md shadow-sm border-otblue-300 focus:border-otblue focus:ring focus:ring-otblue-100 placeholder:text-otsteel-300']) !!}>