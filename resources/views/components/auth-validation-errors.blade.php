@props(['errors'])

@if ($errors->any())
<div {{ $attributes }}>
    <div class="border border-red-600 p-4 bg-red-100 text-red-600">
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif