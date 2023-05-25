<div {{ $attributes->merge(['class' => 'w-full p-4 px-6 border-t border-white cursor-pointer']) }}>
    <div class="flex items-center justify-between font-medium">
        <span class="text-lg">{{ $slot }}</span>
        <span><i class="fas fa-angle-right transition"></i></span>
    </div>
</div>