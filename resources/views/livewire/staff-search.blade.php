<div>
    <div class="mb-4 flex gap-4">

        <div>
            <x-input name="searchTerm" type="text" placeholder="Search Users" wire:model="searchTerm" />
        </div>

    </div>

    <div>


        <x-dashboard.table>
            <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
                <th class="px-2 py-1">Name</th>
                <th class="px-2 py-1">Organization</th>
                <th class="px-2 py-1">Roles</th>
            </tr>

            @foreach ($users as $user)
            <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">


                <td class="px-2 py-1">
                    <a class="flex gap-3 items-center" href="{{ route('dashboard.staff.staffDirectory.staff', $user) }}">
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
                    @if($user->organization)
                    <div class="">{{ $user->organization->name }}</div>
                    <div class="text-otsteel text-sm">{{ $user->organization->domain }}</div>
                    @endif
                </td>
                <td class="px-2 py-1">
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
                    @endphp
                    <div class="px-3 inline-block text-sm rounded-full {{ $classes }}">{{ $v }}</div>
                    @endforeach
                    @endif
                </td>
            </tr>
            @endforeach

        </x-dashboard.table>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
</div>