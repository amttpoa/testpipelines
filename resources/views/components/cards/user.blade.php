@props(['user', 'type' => ''])

<x-cards.main {{ $attributes }}>

    <div class="flex relative gap-6 items-center">
        @if($type)
        <div class="absolute -top-5 -right-5 px-2 py-0.5 bg-otsteel text-sm text-white">
            {{ $type }}
        </div>
        @endif
        <div class="w-40">
            <x-profile-image class="w-40 h-40" :profile="$user->profile" />
        </div>
        <div class="flex-1">
            <div class="text-2xl font-medium">
                <a href="{{ route('admin.users.show', $user) }}">
                    {{ $user->name }}
                </a>
            </div>
            <div class="font-medium">
                {{ $user->profile->title }}
            </div>
            <div class="text-otgray">
                {{ $user->email }}
            </div>
            <div class="text-otgray">
                {{ $user->profile->phone }}
            </div>
            <div class="mt-2">
                <x-user-roles :user="$user" />
            </div>
            @if($user->organization)
            <div class="mt-2 text-xl font-medium">
                <a href="{{ route('admin.organizations.show', $user->organization) }}">{{ $user->organization->name }}</a>
            </div>
            @endif
            @foreach($user->organizations as $organization)
            <div class="font-medium text-sm">
                <a href="{{ route('admin.organizations.show', $organization) }}">{{ $organization->name }}</a>
            </div>
            @endforeach
        </div>
    </div>

</x-cards.main>