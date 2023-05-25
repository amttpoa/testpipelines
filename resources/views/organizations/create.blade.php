<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.organizations.index') }}">Organizations</x-crumbs.a>
            Create Organization
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        <x-form-errors />

        <form method="POST" id="main-form" action="{{ route('admin.organizations.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                <x-fields.input-text label="Name" name="name" class="mb-3" value="{{ Request::get('name') }}" />
                <x-fields.input-text label="Leader" name="leader" class="mb-3" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <x-fields.input-text label="Address" name="address" class="mb-3" />
                <x-fields.input-text label="Address 2" name="address2" class="mb-3" />
            </div>
            <div class="flex gap-3 flex-wrap md:flex-nowrap">
                <x-fields.input-text label="City" name="city" class="md:mb-3 md:flex-1 w-full md:w-auto" />
                <x-fields.input-text label="State" name="state" class="mb-3 flex-1 md:w-32" />
                <x-fields.input-text label="Zip" name="zip" class="mb-3 flex-1 md:w-32" />
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                <x-fields.input-text label="County" name="county" class="" />
                <x-fields.input-text label="Phone" name="phone" class="" />
                <x-fields.input-text label="Fax" name="fax" class="" />
                <x-fields.input-text label="Email" name="email" class="" />
            </div>

            <div class="flex gap-3 mb-4">
                <div>
                    <x-label for="organization_type">Organization Type</x-label>
                    <x-select name="organization_type" :selections="['Customer' => 'Customer','Vendor' => 'Vendor']" />
                </div>
                <div>
                    <x-label for="region">Region</x-label>
                    <x-select name="region" :selections="['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8']" placeholder=" " />
                </div>
            </div>


            <x-label for="domain">Domain</x-label>
            <x-input label="Domain" name="domain" placeholder="otoa.org" class="mb-4" />

            <x-label for="website">Website</x-label>
            <x-input label="Link to your website" name="website" placeholder="https://www.otoa.org/" class="mb-4" />

            <div class="mb-4 flex-1 md:w-30">
                <x-label for="image">Image</x-label>
                <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg" />
            </div>


            <div class="mb-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                <div class="flex gap-3 items-end">
                    <div class="flex-1">
                        <x-label for="website_description">Short Company Description</x-label>
                    </div>
                    <div class="pr-2 text-xs text-otsteel-500"><span x-html="count"></span> of <span x-html="$refs.countme.maxLength"></span> character limit</div>
                </div>
                <x-textarea id="short_description" name="short_description" rows="2" maxlength="250" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" placeholder=""></x-textarea>
            </div>

            <div class="mb-4">
                <x-label for="description">Full Company Description</x-label>
                <x-textarea class="addTiny" rows="5" name="description"></x-textarea>
            </div>

            <div class="mb-4">
                <x-label for="notes">Notes</x-label>
                <x-textarea class="addTiny" rows="5" name="notes"></x-textarea>
            </div>






        </form>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>