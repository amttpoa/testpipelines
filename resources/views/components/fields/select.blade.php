@props(['disabled' => false, 'selections' => '[]', 'selected' => '', 'label', 'name', 'value' => '', 'placeholder' => '', 'required' => false, 'width' => 'w-full', 'xmodel' => ''])

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name }}" class="block font-semibold text-sm">
        {{ $label }}
    </label>

    <select id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $xmodel ? 'x-model=' . $xmodel : '' }} class="block {{ $width }} block py-1 pl-2 rounded-md shadow-sm border-otblue-300 focus:border-otblue focus:ring focus:ring-otblue-100 placeholder:text-gray-400">
        @if($placeholder !== '')
        <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($selections as $key => $selection)
        <option value="{{ $key }}" {{ $key==$selected ? 'selected' : '' }}>{{ $selection }}</option>
        @endforeach
    </select>
</div>