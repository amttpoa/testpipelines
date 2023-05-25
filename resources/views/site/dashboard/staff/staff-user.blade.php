<x-dashboard.layout>
    @section("pageTitle")
    {{ $user->name }}
    @endSection

    <x-breadcrumbs.holder>
        <a href="{{ route('dashboard.staff.staffDirectory') }}">Staff Directory</a>
        <x-breadcrumbs.arrow />
        {{ $user->name }}
    </x-breadcrumbs.holder>

    <div class="flex gap-4">
        <div class="flex-1">
            <div>
                <div class="font-semibold text-2xl">{{ $user->name }}</div>
                <div>
                    {{ $user->profile->address }}
                </div>
                <div>
                    {{ $user->profile->city }}{{ $user->profile->city && $user->profile->state ? ',' : '' }}
                    {{ $user->profile->state }} {{ $user->profile->zip }}
                </div>
                <div>{{ $user->profile->phone }}</div>
                <div><a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a></div>
            </div>

            <table class="mt-4">
                @if($user->profile->birthday)
                <tr>
                    <td class="text-right pr-2 font-semibold">Birthday:</td>
                    <td class="">{{ \Carbon\Carbon::parse($user->profile->birthday)->format('m/d/Y') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="text-right pr-2 font-semibold">Shirt Size:</td>
                    <td class="">{{ $user->profile->shirt_size }}</td>
                </tr>
                <tr>
                    <td class="text-right pr-2 font-semibold">Pants (waist):</td>
                    <td class="">{{ $user->profile->pants_waist }}</td>
                </tr>
                <tr>
                    <td class="text-right pr-2 font-semibold">Pants (inseam):</td>
                    <td class="">{{ $user->profile->pants_inseam }}</td>
                </tr>
                <tr>
                    <td class="text-right pr-2 font-semibold">Shoe Size:</td>
                    <td class="">{{ $user->profile->shoe_size }}</td>
                </tr>
            </table>


            <div class="font-semibold text-2xl mt-4">Emergency Contact Information</div>

            <table class="">
                <tr>
                    <td class="text-right pr-2 font-semibold">Name:</td>
                    <td class="">{{ $user->profile->emergency_name }}</td>
                </tr>
                <tr>
                    <td class="text-right pr-2 font-semibold">Relationship:</td>
                    <td class="">{{ $user->profile->emergency_relationship }}</td>
                </tr>
                <tr>
                    <td class="text-right pr-2 font-semibold">Phone:</td>
                    <td class="">{{ $user->profile->emergency_phone }}</td>
                </tr>
            </table>

        </div>
        <div class="">
            <x-profile-image class="w-72 h-72" :profile="$user->profile" />
        </div>

    </div>
</x-dashboard.layout>