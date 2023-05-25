<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Roles
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.roles.create') }}">Create Role</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.plain>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Permissions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">

                @foreach ($roles as $key => $role)
                <tr>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.roles.edit',$role->id) }}">{{ $role->name }}</a>
                    </td>
                    <td class="px-4 py-3">
                        @foreach($role->permissions->sortBy('name') as $permission)
                        {{ $permission->name }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>

        {!! $roles->render() !!}

    </x-cards.plain>

</x-app-layout>