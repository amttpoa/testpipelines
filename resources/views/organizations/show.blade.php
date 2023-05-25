<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.organizations.index') }}">Organizations</x-crumbs.a>
            {{ $organization->name }}
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.organizations.edit', $organization) }}">Edit Organization</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid xl:grid-cols-2 gap-6 mb-6">

        <x-cards.organization :organization="$organization" />

        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\Organization', 'subject_id' => $organization->id])
        </x-cards.main>

    </div>

    @if($organization->vendorRegistrationSubmissions->isNotEmpty())
    <x-cards.main class="mb-6">
        <h2 class="text-2xl mb-4">Vendor Registrations</h2>

        @foreach($organization->vendorRegistrationSubmissions as $submission)
        <div class="mb-4">
            <div>
                <x-a href="{{ route('admin.vendor-registration-submissions.show', [$submission->conference, $submission]) }}">{{ $submission->conference->name }}</x-a>
            </div>
            <div>
                {{ $submission->sponsorship }}
            </div>
        </div>
        @endforeach
    </x-cards.main>
    @endif

    <x-cards.plain>
        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Roles</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">


                        @foreach ($organization->primaryUsers as $user)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                            <td class="px-4 py-3">

                                <a class="flex gap-3 items-center" href="{{ route('admin.users.show', $user) }}">
                                    <div class="w-10">
                                        <x-profile-image class="w-10 h-10" :profile="$user->profile" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-lg">{{ $user->name }}</div>
                                        <div class="text-otsteel text-sm">{{ $user->email }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <x-user-roles :user="$user" />
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a class="inline-flex items-center gap-1 text-otgold font-semibold" href="{{ route('admin.users.edit',$user->id) }}">
                                    <x-icons.edit class="w-4 h-4" /> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </x-cards.plain>


    <x-cards.plain class="mt-6">
        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Roles</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">


                        @foreach ($organization->users as $user)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                            <td class="px-4 py-3">

                                <a class="flex gap-3 items-center" href="{{ route('admin.users.show', $user) }}">
                                    <div class="w-10">
                                        <x-profile-image class="w-10 h-10" :profile="$user->profile" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-lg">{{ $user->name }}</div>
                                        <div class="text-otsteel text-sm">{{ $user->email }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                @php
                                $classes = 'bg-otgold text-white';
                                if($v == 'Admin') {$classes = 'bg-otblue text-white';}
                                if($v == 'Super Admin') {$classes = 'bg-black text-white';}
                                if($v == 'Organization Admin') {$classes = 'bg-otsteel text-white';}
                                if($v == 'Staff') {$classes = 'bg-red-800 text-white';}
                                if($v == 'Conference Instructor') {$classes = 'bg-red-800 text-white';}
                                if($v == 'Staff Instructor') {$classes = 'bg-red-800 text-white';}
                                if($v == 'Vendor Management') {$classes = 'bg-blue-800 text-white';}
                                if($v == 'Vendor') {$classes = 'bg-green-800 text-white';}
                                @endphp
                                <div class="px-3 inline-block text-sm rounded-full {{ $classes }}">{{ $v }}</div>
                                @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a class="inline-flex items-center gap-1 text-otgold font-semibold" href="{{ route('admin.users.edit',$user->id) }}">
                                    <x-icons.edit class="w-4 h-4" /> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </x-cards.plain>

    <x-cards.main class="mt-6" x-data="{showLog:false}">
        <div class="cursor-pointer font-medium" @click="showLog=!showLog">View Activity Log</div>
        <table class="mt-6 w-full" x-show="showLog">
            <tbody class="divide-y divide-cdblue-500 align-top">
                @foreach($activities as $activity)
                <tr>
                    <td class="whitespace-nowrap">{{ $activity->created_at->format('F jS Y h:i A') }}</td>
                    <td>
                        {{ $activity->description }}
                    </td>
                    <td>{{ $activity->causer ? $activity->causer->name : '' }}</td>
                    <td class="textLeft">
                        @if($activity->description == 'updated')
                        @if($activity->properties->isNotEmpty())
                        @foreach($activity->properties['attributes'] as $key => $val)
                        <div>
                            {{ $key }} From
                            @if(isset($activity->properties['old'][$key]))
                            <span class="font-semibold">{{ $activity->properties['old'][$key] }}</span>
                            @else
                            <span class="font-semibold text-red-700 text-sm">null</span>
                            @endif
                            to
                            @if(isset($activity->properties['attributes'][$key]))
                            <span class="font-semibold">{{ $activity->properties['attributes'][$key] }}</span>
                            @else
                            <span class="font-semibold text-red-700 text-sm">null</span>
                            @endif
                        </div>
                        @endforeach
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-cards.main>

</x-app-layout>