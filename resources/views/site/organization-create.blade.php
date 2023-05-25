<x-site-layout>
    <x-auth-card>
        <x-slot name="logo">

        </x-slot>

        <div class="text-3xl font-bold font-blender text-otblue mb-4">Create Your Company Profile</div>

        <form method="POST" action="{{ route('organization.store') }}" enctype="multipart/form-data">
            @csrf

            @if(request()->get('company') == 'incomplete')
            <div class="flex gap-6 items-center mb-4 text-semibold bg-otgold-100 border border-otgold rounded-xl p-6">
                <x-icons.warning class="w-10 h-10 text-otgold" />
                <div class="flex-1">
                    You must complete your company profile before you can register to be a vendor at the conference.
                </div>
            </div>
            @endif

            <div class="mb-4">
                All fields below, including the company logo and company description are <strong>REQUIRED</strong>.
                {{-- This is your opportunity to reach your customer.
                All fields below, including the company logo are <strong>REQUIRED</strong> and essential to provide your company brand recognition on the OTOA website. --}}
            </div>

            <div class="font-medium text-2xl mb-4">
                {{ $organization->name }}
            </div>

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
            <div class="mb-4 text-red-700 hidden">
                Please provide your company logo/brand/image
            </div>
            @endif
            <div class="mb-4 flex-1 md:w-30">
                <x-label for="image" class="text-lg">Please provide your company logo/brand/image</x-label>
                <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg" required />
            </div>

            <div class="mb-4">
                <x-label for="description" class="text-lg">Company Description</x-label>
                <div class="text-xs">This will appear on your public company profile page.</div>
                <x-textarea class="addTiny" rows="5" name="description">{{ $organization->description }}</x-textarea>
            </div>

            <x-button-site class="">
                Submit
            </x-button-site>
        </form>
    </x-auth-card>
</x-site-layout>