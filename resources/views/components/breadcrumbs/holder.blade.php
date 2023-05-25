<div {{ $attributes->merge(['class' => 'mb-6 flex flex-wrap items-center gap-x-2 font-medium text-sm md:text-base text-otgray']) }}>
    <x-breadcrumbs.dashboard />
    <x-breadcrumbs.arrow />
    {{ $slot }}
</div>