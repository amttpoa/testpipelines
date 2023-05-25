<x-site-layout>
    @section("pageTitle")
    Create User Account
    @endSection

    <x-auth-card>
        <x-slot name="logo" class="text-center sm:text-left">
            <a href="/" class="hidden sm:block">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>

            <div class="w-full sm:w-48 mt-10 mb-6">
                <div>Membership <strong>REQUIRED</strong> to attend TTPOA Training</div>
            </div>
        </x-slot>


        <div class="text-3xl font-bold font-blender mb-4">Create User Account</div>
        <div class="mb-4">

            <div class="font-medium mt-4">
                Individuals seeking TTPOA membership and register for training
            </div>
            <ul class="list-disc ml-8 text-sm">
                <li>Create a user account</li>
                <li>Access your user account dashboard</li>
                <li>Subscribe to an TTPOA membership plan</li>
                <li>Register for training courses</li>
            </ul>

        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="flex flex-col gap-4 mb-4" x-data="{radio:null}">
                <div class="text-3xl font-bold font-blender">Choose Your User Account Type</div>
                <div>
                    <label for="radio1" :class="{'bg-otgold text-white' : radio == 'customer', 'bg-white text-black' : radio != 'customer'}" class="flex gap-6 items-center border border-black px-4 py-2 rounded-md">
                        <div>
                            <input type="radio" name="account_type" id="radio1" x-model="radio" value="customer" required />
                        </div>
                        <div>
                            <x-icons.users class="w-12 h-12" />
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-xl">
                                Standard User
                            </div>
                            <div class="text-sm">
                                Individual seeking TTPOA membership and register for training
                            </div>
                        </div>
                    </label>
                </div>
                <div>
                    <label for="radio2" :class="{'bg-otgray text-white' : radio == 'admin', 'bg-white text-black' : radio != 'admin'}" class="flex gap-6 items-center border border-black px-4 py-2 rounded-md">
                        <div>
                            <input type="radio" name="account_type" id="radio2" x-model="radio" value="admin" required />
                        </div>
                        <div>
                            <x-icons.organization class="w-12 h-12" />
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-xl">
                                Organization Administrator
                            </div>
                            <div class="text-sm">
                                Create a user account, view individuals from your agency, add new ones, and sign them up for training.
                            </div>
                        </div>
                    </label>
                </div>
                <div>
                    <label for="radio3" :class="{'bg-otblue text-white' : radio == 'vendor', 'bg-white text-black' : radio != 'vendor'}" class="flex gap-6 items-center border border-black px-4 py-2 rounded-md">
                        <div>
                            <input type="radio" name="account_type" id="radio3" x-model="radio" value="vendor" required />
                        </div>
                        <div>
                            <x-icons.building class="w-12 h-12" />
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-xl">
                                Vendor
                            </div>
                            <div class="text-sm">
                                Create a company user account, sign-up for the vendor show, and manage registrations.
                            </div>
                        </div>
                    </label>
                </div>
            </div>



            <div class="mb-4">
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" name="name" :value="old('name')" required autofocus />
            </div>

            <div class="mb-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <x-label for="password" :value="__('Password')" />
                    <x-input id="password" type="password" name="password" required autocomplete="new-password" />
                </div>
                <div class="mb-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-input id="password_confirmation" type="password" name="password_confirmation" required />
                </div>
            </div>

            <div class="mb-4">
                @livewire('organization-autocomplete', ['organization_type' => 'Customer', 'required' => true])
            </div>

            <div class="mb-4">
                <x-label for="phone">Cell Phone</x-label>
                <x-input :value="old('phone')" x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" type="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" id="phone" name="phone" required />
                <div class="text-sm block font-light">Your cell phone number is needed to directly contact you if there is a change to the course you are attending.</div>
            </div>

            <x-fields.input-text label="Address" name="address" class="mb-4 hidden" />

            <div class="grid grid-cols-4 gap-3 hidden">
                <x-fields.input-text label="City" name="city" class="mb-4 col-span-2" />
                <x-fields.input-text label="State" name="state" class="mb-4" />
                <x-fields.input-text label="Zip" name="zip" class="mb-4" />
            </div>
            <x-fields.input-text label="Bot" name="bot" class="mb-4 hidden" />

            <div class="flex items-center justify-end mb-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button-site class="ml-4">
                    {{ __('Register') }}
                </x-button-site>
            </div>
        </form>
    </x-auth-card>
</x-site-layout>