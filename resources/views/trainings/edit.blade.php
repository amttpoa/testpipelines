<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.trainings.show', $training) }}">{{ $training->name }}</x-crumbs.a>
            Edit Training
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.trainings.update', $training) }}">
            @csrf
            @method('PATCH')

            <div class="max-w-lg mb-3">
                <div class="mb-3">
                    <x-label for="Name">Name</x-label>
                    <x-input id="name" name="name" value="{{ $training->name }}" />
                </div>
            </div>

            <div class="flex gap-3">
                <x-fields.input-text label="Hours" type="number" name="hours" value="{{ $training->hours }}" class="mb-3" />
                <x-fields.input-text label="Days" type="number" name="days" value="{{ $training->days }}" class="mb-3" />
                <x-fields.input-text label="Price" type="number" name="price" value="{{ $training->price }}" class="mb-3" />
                <x-fields.input-text label="Order" type="number" name="order" value="{{ $training->order }}" class="mb-3" />

                <div class="mb-3">
                    <x-label for="active">Active</x-label>
                    <input type="checkbox" name="active" id="active" value="true" {{ $training->active ? 'checked' : '' }} class="ml-3" />
                </div>
            </div>

            <div class="mb-3">
                <x-label for="short_description">Short Description</x-label>
                <x-textarea rows="5" class="addTiny" name="short_description">{{ $training->short_description }}</x-textarea>
            </div>
            <div class="">
                <x-label for="description">Description</x-label>
                <x-textarea rows="5" class="addTiny" name="description">{{ $training->description }}</x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>