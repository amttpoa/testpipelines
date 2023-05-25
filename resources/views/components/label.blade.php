@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm']) }}>
    {{ $value ?? $slot }}
</label>