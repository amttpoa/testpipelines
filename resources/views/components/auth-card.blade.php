<div {!! $attributes->merge(['class' => 'py-16 bg-otsteel flex-1']) !!}>

    <div class="mx-auto max-w-3xl sm:flex {{ $logo->isNotEmpty() ? 'gap-8' : '' }} items-center px-6 py-4 bg-white shadow overflow-hidden">

        <div class="text-center">
            <div>{{ $logo }}</div>
        </div>

        <div class="flex-1">
            {{ $slot }}
        </div>

    </div>

</div>