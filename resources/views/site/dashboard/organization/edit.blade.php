<x-dashboard.layout>
    @section("pageTitle")
    My Company
    @endSection

    <x-breadcrumbs.holder>
        My Company
    </x-breadcrumbs.holder>

    <div class="font-medium text-2xl mb-4">
        {{ $organization->name }}
    </div>

    <form method="POST" action="{{ route('dashboard.company.update') }}" enctype="multipart/form-data">
        @csrf
        @method("PATCH")

        <x-fields.input-text label="Address" name="address" value="{{ $organization->address }}" class="mb-4" required />

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
            <x-fields.input-text label="City" name="city" value="{{ $organization->city }}" class=" col-span-2" required />
            <x-fields.input-text label="State" name="state" value="{{ $organization->state }}" class="" required />
            <x-fields.input-text label="Zip" name="zip" value="{{ $organization->zip }}" class="" required />
        </div>

        <x-label for="website">Website</x-label>
        <x-input label="Link to your website" name="website" value="{{ $organization->website }}" placeholder="https://www.otoa.org/" class="mb-4" />

        @if($organization->image)
        <img class="max-h-16 max-w-32 mb-4" src="{{ Storage::disk('s3')->url('organizations/' . $organization->image) }}" />
        @else
        <div class="mb-4 text-red-700">
            You have not provided a company logo.
        </div>
        @endif
        <div class="mb-4 flex-1 md:w-30">
            <x-label for="image">Change Image</x-label>
            <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg" />
        </div>

        <div class="mb-4">
            <x-label for="description">Company Description</x-label>
            <x-textarea class="addTiny" rows="5" name="description">{{ $organization->description }}</x-textarea>
        </div>

        <x-button-site class="">
            Submit
        </x-button-site>
    </form>

</x-dashboard.layout>