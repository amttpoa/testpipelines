<div class="flex-1 py-2 flex flex-wrap items-center gap-x-2 font-semibold text-base text-otgray">
    <a class="text-black flex items-center gap-2" href={{ route('admin.dashboard') }}>
        <i class="fa-solid fa-house text-sm"></i> Home
    </a>
    <x-crumbs.arrow />
    {{ $slot }}
</div>