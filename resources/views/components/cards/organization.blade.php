@props(['organization'])

<x-cards.main {{ $attributes }}>



    <h2 class="text-2xl font-medium mb-4">
        <a href="{{ route('admin.organizations.show', $organization) }}">{{ $organization->name }}</a>
    </h2>
    <div class="flex gap-3">
        <div class="flex-1">
            <div class="font-medium">{{ $organization->leader }}</div>
            <div>{{ $organization->address }}</div>
            <div>{{ $organization->address2 }}</div>
            <div>
                {{ $organization->city }}{{ $organization->city ? ',' : '' }}
                {{ $organization->state }}
                {{ $organization->zip }}
            </div>
            <div class="mb-4">{{ $organization->county }}</div>
            <div class="font-medium text-xl">{{ $organization->organization_type }}</div>
            @if($organization->website)
            <div>
                <x-a href="{{ $organization->website }}" target="blank">{{ $organization->website }}</x-a>
            </div>
            @endif
        </div>
        <div class="text-right text-sm">
            @if($organization->image)
            <div class="mb-2">
                <img class="max-w-[160px] max-h-20 inline" src="{{ Storage::disk('s3')->url('organizations/' . $organization->image) }}" />
            </div>
            @endif
            @if($organization->phone)
            <div>Phone: {{ $organization->phone }}</div>
            @endif
            @if($organization->fax)
            <div>Fax: {{ $organization->fax }}</div>
            @endif
            @if($organization->email)
            <div>
                <x-a href="mailto:{{ $organization->email }}">{{ $organization->email }}</x-a>
            </div>
            @endif
        </div>
    </div>


</x-cards.main>