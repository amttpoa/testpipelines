<div {{ $attributes->merge(['class' => 'overflow-hidden w-full']) }}>
    <div class="overflow-x-auto w-full">
        <table class="w-full">
            {{ $slot }}
        </table>
    </div>
</div>