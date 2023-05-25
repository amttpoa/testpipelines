<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            Create Training
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.trainings.store') }}">
            @csrf

            <div class="max-w-lg mb-3">
                <div class="mb-3">
                    <x-label for="Name">Name</x-label>
                    <x-input id="name" name="name" />
                </div>
            </div>

            <div class="flex gap-3">
                <x-fields.input-text label="Hours" type="number" name="hours" class="mb-3" />
                <x-fields.input-text label="Days" type="number" name="days" class="mb-3" />
                <x-fields.input-text label="Price" type="number" name="price" class="mb-3" />
                <x-fields.input-text label="Order" type="number" name="order" class="mb-3" />
            </div>
            <div class="flex gap-3">
                <div class="mb-3">
                    <x-label for="active">Active</x-label>
                    <input type="checkbox" name="active" id="active" value="true" />
                </div>
            </div>

            <div class="mb-3">
                <x-label for="short_description">Short Description</x-label>
                <x-textarea rows="5" class="addTiny" name="short_description"></x-textarea>
            </div>
            <div class="">
                <x-label for="description">Description</x-label>
                <x-textarea rows="5" class="addTiny" name="description"></x-textarea>
            </div>

        </form>



    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>