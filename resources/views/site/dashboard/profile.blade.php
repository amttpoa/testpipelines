<x-dashboard.layout>
    @section("pageTitle")
    My Profile
    @endSection

    <x-breadcrumbs.holder>
        My Profile
    </x-breadcrumbs.holder>


    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div class="mt-10 sm:mt-0">
        @livewire('profile.two-factor-authentication-form')
    </div>
    @endif

    <form method="POST" id="main-form" enctype="multipart/form-data" action="{{ route('dashboard.profilePatch') }}">
        @csrf
        @method('PATCH')



        <div class="grid sm:grid-cols-2 gap-4">

            <div>
                <x-fields.input-text label="Name" name="name" value="{!! $profile->user->name !!}" class="mb-3" />

                @can('general-staff')
                <x-fields.input-text label="Title" name="title" value="{!! $profile->title !!}" class="mb-3" />
                @endcan

                <div class="flex gap-3">
                    <div class="mb-3">
                        <x-label for="phone">Cell Phone</x-label>
                        <x-input x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" type="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" id="phone" name="phone" value="{{ $profile->phone }}" required />
                    </div>
                    @can('general-staff')
                    <div class="mb-3">
                        <x-label for="birthday">Birthday</x-label>
                        <x-input type="date" id="birthday" name="birthday" value="{{ $profile->birthday ? $profile->birthday->format('Y-m-d') : '' }}" />
                    </div>
                    @endcan
                </div>

            </div>

            <div class="mb-4">
                @can('vendor')
                <div class="">
                    @livewire('organization-autocomplete', ['organization_type' => 'Vendor', 'required' => true, 'label' => 'Company Name', 'organization_id' => $profile->user->organization ? $profile->user->organization_id : '', 'organization_name' => $profile->user->organization ? $profile->user->organization->name : ''] )
                </div>
                @else
                <div class="">
                    @livewire('organization-autocomplete', ['organization_type' => 'Customer', 'required' => true, 'label' => 'Primary Organization or Employer', 'organization_id' => $profile->user->organization ? $profile->user->organization_id : '', 'organization_name' => $profile->user->organization ? $profile->user->organization->name : ''] )
                </div>
                <div class="mt-3">
                    @livewire('organization-autocomplete', ['organization_type' => 'Customer', 'ext' => 's[]', 'label' => 'Secondary Organization - Team, Task Force, etc.', 'organization_id' => $profile->user->organizations->count() > 0 ? $profile->user->organizations[0]->id : '', 'organization_name' => $profile->user->organizations->count() > 0 ? $profile->user->organizations[0]->name : ''] )
                </div>
                <div class="mt-3">
                    @livewire('organization-autocomplete', ['organization_type' => 'Customer', 'ext' => 's[]', 'label' => 'Additional Organization - if needed', 'organization_id' => $profile->user->organizations->count() > 1 ? $profile->user->organizations[1]->id : '', 'organization_name' => $profile->user->organizations->count() > 1 ? $profile->user->organizations[1]->name : ''] )
                </div>
                @endif
            </div>
        </div>

        @can('general-staff')

        <x-fields.input-text label="Your Home Address" name="address" value="{!! $profile->address !!}" class="mb-4" />
        <div class="grid md:grid-cols-3 gap-4 mb-4">
            <x-fields.input-text label="City" name="city" value="{!! $profile->city !!}" />
            <x-fields.input-text label="State" name="state" value="{!! $profile->state !!}" />
            <x-fields.input-text label="Zip" name="zip" value="{!! $profile->zip !!}" />
        </div>
        <div class="">
            <x-label for="bio">Bio</x-label>
            <x-textarea rows="5" class="addTiny" name="bio">{{ $profile->bio }}</x-textarea>
        </div>

        <h2 class="text-2xl mb-4 mt-8">Staff Related Information</h2>

        <div class="mb-2"><span class="font-medium">Note:</span> All sizing is standard MEN'S sizes unless indicated otherwise.</div>

        <div class="flex gap-3">
            <x-fields.select label="Shirt Size" name="shirt_size" :selections="Config::get('site.shirt_size')" :selected="$profile->shirt_size" placeholder=" " class="mb-3" />
            <x-fields.select label="Pants (waist)" name="pants_waist" :selections="Config::get('site.pants_waist')" :selected="$profile->pants_waist" placeholder=" " class="mb-3" />
            <x-fields.select label="Pants (inseam)" name="pants_inseam" :selections="Config::get('site.pants_inseam')" :selected="$profile->pants_inseam" placeholder=" " class="mb-3" />
            <x-fields.select label="Shoe Size" name="shoe_size" :selections="Config::get('site.shoe_size')" :selected="$profile->shoe_size" placeholder=" " class="mb-3" />
        </div>

        <div class="grid gap-3 lg:grid-cols-3 mb-3">
            <x-fields.input-text label="Emergency Contact" name="emergency_name" value="{{ $profile->emergency_name }}" />
            <x-fields.input-text label="Emergency Contact Relationship" name="emergency_relationship" value="{{ $profile->emergency_relationship }}" />
            <div>
                <x-label for="emergency_phone">Emergency Contact Phone</x-label>
                <x-input x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" value="{{ $profile->emergency_phone }}" id="emergency_phone" name="emergency_phone" />
            </div>
        </div>
        @endcan

        <div class="mt-6">
            <x-button form="main-form">Update My Profile</x-button>
        </div>
    </form>

</x-dashboard.layout>