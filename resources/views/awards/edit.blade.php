<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.awards.index') }}">Awards</x-crumbs.a>
            Edit Award
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.awards.update', $award) }}">
            @csrf
            @method('PATCH')

            <x-fields.input-text label="Name" name="name" class="mb-3" value="{!! $award->name !!}" />
            <x-fields.input-text label="slug" name="slug" class="mb-3" value="{!! $award->slug !!}" />
            <x-fields.input-text label="order" name="order" class="mb-3" value="{!! $award->order !!}" />
            <x-fields.input-text label="image" name="image" class="mb-3" value="{!! $award->image !!}" />
            <x-fields.input-text label="sponsor_name" name="sponsor_name" class="mb-3" value="{!! $award->sponsor_name !!}" />
            <x-fields.input-text label="sponsor_image" name="sponsor_image" class="mb-3" value="{!! $award->sponsor_image !!}" />
            <x-fields.input-text label="sponsor_website" name="sponsor_website" class="mb-3" value="{!! $award->sponsor_website !!}" />

            <div class="">
                <x-label for="short_description">Short short_Description</x-label>
                <x-textarea rows="5" class="addTiny" name="short_description">{{ $award->short_description }}</x-textarea>
            </div>
            <div class="">
                <x-label for="description">Description</x-label>
                <x-textarea rows="5" class="addTiny" name="description">{{ $award->description }}</x-textarea>
            </div>

        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>