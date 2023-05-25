<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.radios.index') }}">Radios</x-crumbs.a>
            Edit Radio
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.radios.update', $radio) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Name" name="name" class="mb-3" value="{!! $radio->name !!}" />

            <div class="">
                <x-label for="description">description</x-label>
                <x-textarea rows="5" class="addTiny" name="description">{{ $radio->description }}</x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>