<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.roles.index') }}">Roles</x-crumbs.a>
            Edit Role
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.roles.update', $role) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex">
                <x-fields.input-text label="Name" name="name" class="mb-3" value="{{ $role->name }}" />
            </div>

            <x-label for="permission[]">Permission</x-label>
            <div class="columns-5">
                @foreach($permission as $value)
                <div>
                    <label>
                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                        {{ $value->name }}
                    </label>
                </div>
                @endforeach
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>