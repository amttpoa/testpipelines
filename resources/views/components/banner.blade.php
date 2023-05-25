@props(['bg' => ''])

<div {{ $attributes->merge(['class' => 'h-48 bg-black bg-cover bg-center']) }} style="background-image:url({{ $bg }});">
    <div class="h-full" style="background-color: rgba(0,0,0,.7);">
        <div class="px-4 h-full flex flex-col justify-center max-w-7xl mx-auto">
            <div class="text-otgold font-blender font-bold text-center">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>