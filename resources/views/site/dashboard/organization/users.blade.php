<x-dashboard.layout>
    @section("pageTitle")
    Users
    @endSection

    <div class="lg:flex lg:gap-3 lg:flex-1">
        <x-breadcrumbs.holder class="flex-1">
            <a class="text-black" href="{{ route('dashboard.organization.index') }}">My Organization</a>
            <x-breadcrumbs.arrow />
            Users
        </x-breadcrumbs.holder>
        <div>
            @include('site.dashboard.organization.organization-chooser')
        </div>
    </div>


    <div class="mb-4 text-right">
        <x-button-link-site href="{{ route('dashboard.organization.user-create') }}">Add User</x-button-link-site>
    </div>

    <x-info-h>Users in your organization</x-info-h>

    <div class="border-t border-otgray bg-otgray-50">
        @foreach ($users as $user)
        <div class="">
            <a class="flex gap-3 items-center p-3 border-b border-otgray" href="{{ route('dashboard.organization.user', $user) }}">
                <div class="w-16">
                    <x-profile-image class="w-16 h-16" :profile="$user->profile" />
                </div>
                <div class="flex-1">
                    <div class="lg:flex lg:gap-4 items-center">
                        <div class="lg:w-1/2">
                            <div class="text-xl font-medium">{{ $user->name }}</div>
                            <div>
                                {{ $user->profile->phone }}
                            </div>
                            <div class="text-sm font-otgray">
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="lg:flex-1">
                            @if($user->subscribed())
                            <div class="font-medium">{{ $user->subscription()->authorize_plan }}</div>
                            @else
                            <div class="font-light text-otgray">Not subscibed</div>
                            @endif
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="text-4xl font-medium">{{ $user->trainingCourseAttendees->count() }}</div>
                            <div class="flex-1 text-sm leading-tight">
                                <div>Advanced Training</div>
                                <div>Courses{{ $user->trainingCourseAttendees->count() > 1 ? 's' : '' }} Attending</div>
                            </div>
                        </div>
                    </div>

                </div>
            </a>
        </div>
        @endforeach
    </div>

    <x-dashboard.table class="hidden">
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Name</th>
            <th class="px-2 py-1">Membership Status</th>
        </tr>
        @foreach ($users as $user)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1">
                <a class="flex gap-3 items-center" href="{{ route('dashboard.organization.user', $user) }}">
                    <div class="w-10">
                        <x-profile-image class="w-10 h-10" :profile="$user->profile" />
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-lg">{{ $user->name }}</div>
                        <div class="text-otsteel text-sm">{{ $user->email }}</div>
                    </div>
                </a>
            </td>
            <td class="px-2 py-1">
                {{ $user->subscribed() ? 'Subscribed' : '' }}
            </td>
        </tr>
        @endforeach

    </x-dashboard.table>

</x-dashboard.layout>