<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.staffs.index') }}">Staff</x-crumbs.a>
            Edit Staff
        </x-crumbs.holder>
        <x-page-menu>
            <form method="POST" action="{{ route('admin.staffs.destroy',  $staff) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.staffs.update', $staff) }}">
            @csrf
            @method('PATCH')

            <x-fields.select width="w-auto" label="Section" name="staff_section_id" :selections="$sections" :selected="$staff->staff_section_id" class="mb-3" required />
            <x-fields.select width="w-auto" label="User" name="user_id" :selections="$users" :selected="$staff->user_id" placeholder=" " class="mb-3" required />
            <x-fields.input-text label="Title" name="title" class="mb-3 w-80" value="{{ $staff->title }}" />
            <x-fields.input-text label="Order" name="order" type="number" class="mb-3 w-40" value="{{ $staff->order }}" required />



        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>