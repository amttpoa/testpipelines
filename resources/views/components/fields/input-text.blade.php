@props(['disabled' => false, 'label', 'name', 'value' => '', 'type' => 'text', 'required' => false, 'xmodel' => ''])


<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name }}" class="block font-semibold text-sm">
        {{ $label }}
    </label>

    <input {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" type="{{ $type }}" {{ $required ? 'required' : '' }} {{ $xmodel ? 'x-model=' . $xmodel : '' }} class="block w-full py-1 px-2 rounded-md shadow-sm border-otblue-300 focus:border-otblue focus:ring focus:ring-otblue-100 placeholder:text-gray-400" />
</div>