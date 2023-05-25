@props(['disabled' => false, 'selections' => '[]', 'selected' => '', 'name', 'value' => '', 'placeholder' => '', 'required' => false, 'width' => 'w-full'])

<select name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'block py-1 pl-2 rounded-md shadow-sm border-otblue-300 max-w-full focus:border-otblue focus:ring focus:ring-otblue-100 placeholder:text-gray-400']) }}>
    @if($placeholder !== '')
    <option value="">{{ $placeholder }}</option>
    @endif
    @foreach($selections as $key => $selection)
    <option value="{{ $key }}" {{ $key==$selected ? 'selected' : '' }}>{{ $selection }}</option>
    @endforeach
</select>