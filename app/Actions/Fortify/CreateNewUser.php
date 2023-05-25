<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Profile;
use App\Models\Organization;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'bot' => Rule::in(['']),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // if (array_key_exists('bot', $input)) {
        //     if ($input['bot']) {
        //         // return redirect()->route('home')->with('bot', 'bot');
        //         return null;
        //     }
        // }

        $organization_id = $input['organization_id'];
        if ($organization_id == null or $organization_id == '0') {
            $organization = Organization::where('name', $input['organization_name'])->first();
            if ($organization) {
                $organization_id = $organization->id;
            }
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'organization_id' => $organization_id,
        ]);

        $profile = new Profile();
        if (array_key_exists('title', $input)) {
            $profile->title = $input['title'];
        }
        $profile->organization_name = $input['organization_name'];
        $profile->phone = $input['phone'];
        $user->profile()->save($profile);

        if ($input['account_type'] == 'customer') {
            $user->assignRole('Customer');
        }
        if ($input['account_type'] == 'vendor') {
            $user->assignRole('Vendor');
        }
        if ($input['account_type'] == 'admin') {
            $user->assignRole(['Customer', 'Pending Admin']);
        }


        return $user;
    }
}
