<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.users.index') }}">Users</x-crumbs.a>
            Create User
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        {!! Form::open(array('route' => 'admin.users.store','method'=>'POST', 'id' => 'main-form')) !!}


        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-fields.input-text label="Name" name="name" class="mb-3" value="" />
                <x-fields.input-text label="Email" name="email" class="mb-3" value="" />

                <div class="grid grid-cols-2 gap-3">
                    <x-fields.input-text label="Password" name="password" type="password" class="mb-3" />
                    <x-fields.input-text label="Confirm Password" name="confirm-password" type="password" class="mb-3" />
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="mb-3">
                        <x-label for="phone">Phone</x-label>
                        <x-input x-data="{}" x-mask="(999) 999-9999" value="" placeholder="(216) 555-1212" id="phone" name="phone" />
                    </div>
                    <x-fields.input-text label="Title" name="title" value="" class="mb-3" />
                    <x-fields.input-text label="Birthday" name="birthday" type="date" value="" class="mb-3" />
                </div>
            </div>

            <div>
                <div class="font-medium text-2xl">Organization</div>

                <div class="mt-2">
                    @livewire('organization-autocomplete', ['organization_id' => '', 'organization_name' => ''] )
                </div>
                <div class="mt-2">
                    @livewire('organization-autocomplete', ['ext' => 's[]', 'organization_id' => '', 'organization_name' => ''] )
                </div>
                <div class="mt-2">
                    @livewire('organization-autocomplete', ['ext' => 's[]', 'organization_id' => '', 'organization_name' => ''] )
                </div>
            </div>
        </div>


        <div class="mb-2">
            <x-label for="roles[]">Roles</x-label>
            <div class="columns-5 inline-block">
                @foreach($roles as $key => $role)
                <label class="flex gap-3 items-center mb-2">
                    <input type="checkbox" name="roles[]" value="{{ $key }}" />
                    {{ $role }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-2">
            <x-label for="send_email">Send Email</x-label>
            <div class="">
                <label class="flex gap-3 items-center mb-2">
                    <input type="checkbox" name="send_email" value="send" />
                    Send an email to the new user
                </label>
            </div>
        </div>

        {!! Form::close() !!}



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>