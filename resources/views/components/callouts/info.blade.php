<div {{ $attributes->merge(['class' => 'flex gap-6 items-center bg-otgold-100 border border-otgold rounded-xl p-4']) }}>
    <x-icons.info class="w-10 h-10 text-otgold" />
    <div class="flex-1 text-lg ">
        {{ $slot }}
    </div>
</div>