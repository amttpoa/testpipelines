@props(['disabled' => false, 'label', 'name', 'value' => '', 'type' => 'text'])


<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name }}" class="block font-semibold text-sm">
        {{ $label }}
    </label>

    <input {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" id="{{ $name }}" value="{{ $value ? date('m/d/Y', strtotime($value)) : '' }}" type="{{ $type }}" autocomplete="off" class="addDatePicker block w-full py-1 px-2 rounded-md shadow-sm border-cdblue-30 focus:border-cdblue-70 focus:ring focus:ring-cdblue-30 focus:ring-opacity-30" />
</div>