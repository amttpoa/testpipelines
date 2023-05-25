<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.staffs.index') }}">Staff</x-crumbs.a>
            Create Staff
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.staffs.store') }}">
            @csrf

            <x-fields.select width="w-auto" label="Section" name="staff_section_id" :selections="$sections" class="mb-3" required />
            <x-fields.select width="w-auto" label="User" name="user_id" :selections="$users" placeholder=" " class="mb-3" required />
            <x-fields.input-text label="Title" name="title" class="mb-3 w-80" />
            <x-fields.input-text label="Order" name="order" type="number" class="mb-3 w-40" required />


        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>