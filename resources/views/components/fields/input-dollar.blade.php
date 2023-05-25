@props(['disabled' => false, 'label', 'name', 'value' => '', 'type' => 'number', 'step' => '.01'])


<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name }}" class="block font-semibold text-sm">
        {{ $label }}
    </label>

    <div class="dollar">
        <input {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" type="{{ $type }}" step="{{ $step }}" class="block w-full py-1 px-2 rounded-md shadow-sm border-cdblue-500 focus:border-cdblue focus:ring focus:ring-cdblue-300 focus:ring-opacity-30" />
    </div>
</div>