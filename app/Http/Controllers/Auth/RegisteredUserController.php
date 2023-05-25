<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\UserEmailFree;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;

class RegisteredUserController extends Controller
{
    public function choice()
    {
        Redirect::setIntendedUrl(url()->previous());
        return view('auth.register-choice');
    }
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        // Redirect::setIntendedUrl(url()->previous());
        $organizations = Organization::pluck('name', 'id')->all();
        return view('auth.register', compact('organizations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'organization_id' => ''
        ]);

        if ($request->bot) {
            return redirect()->route('home')->with('bot', 'bot');
        }

        $organization_id = $request->organization_id;
        if ($organization_id == null or $organization_id == '0') {
            $organization = Organization::where('name', $request->organization_name)->first();
            if ($organization) {
                $organization_id = $organization->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organization_id,
        ]);

        $profile = new Profile();
        $profile->title = $request->title;
        $profile->organization_name = $request->organization_name;
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->zip = $request->zip;
        $user->profile()->save($profile);

        $user->assignRole('Customer');


        $template = EmailTemplate::where('code', 'account-created-customer')->first();
        $subject = $template->subject;

        $body = $template->body;
        $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

        Mail::send('emails.user-registered', compact('user', 'body'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('You have registered at otoa.org');
        });


        event(new Registered($user));

        Auth::login($user);


        $check = UserEmailFree::where('email', $user->email)->where('used_at', null)->first();
        if ($check) {
            $user = auth()->user();
            $user->createOrGetStripeCustomer();
            $user->newSubscription('default', config('site.stripe_standard_subscription'))
                ->withCoupon(config('site.stripe_discount'))
                ->add();
            $check->used_at = now();
            $check->update();
            return redirect()->route('dashboard', ['subscription' => 'started']);
        }


        // return redirect(RouteServiceProvider::HOME);
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function createVendor()
    {
        // Redirect::setIntendedUrl(url()->previous());
        $organizations = Organization::pluck('name', 'id')->all();
        return view('auth.register-vendor', compact('organizations'));
    }

    public function storeVendor(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'organization_id' => ''
        ]);

        if ($request->bot) {
            return redirect()->route('home')->with('bot', 'bot');
        }

        $organization_id = $request->organization_id;
        if ($organization_id == null or $organization_id == '0') {
            $organization = Organization::where('name', $request->organization_name)->first();
            if ($organization) {
                $organization_id = $organization->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organization_id,
        ]);

        $profile = new Profile();
        $profile->title = $request->title;
        $profile->organization_name = $request->organization_name;
        $profile->phone = $request->phone;
        // $profile->address = $request->address;
        // $profile->city = $request->city;
        // $profile->state = $request->state;
        // $profile->zip = $request->zip;
        $user->profile()->save($profile);

        $user->assignRole('Vendor');


        Mail::send('emails.user-registered', compact('user'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('You have created a vendor company user profile at otoa.org');
        });

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        // return redirect()->intended(RouteServiceProvider::HOME);
        if ($user->organization_id) {
            if (!$user->organization->address) {
                return redirect()->route('organization.create');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }


    public function createAdmin()
    {
        // Redirect::setIntendedUrl(url()->previous());
        $organizations = Organization::pluck('name', 'id')->all();
        return view('auth.register-admin', compact('organizations'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'organization_id' => ''
        ]);

        if ($request->bot) {
            return redirect()->route('home')->with('bot', 'bot');
        }

        $organization_id = $request->organization_id;
        if ($organization_id == null or $organization_id == '0') {
            $organization = Organization::where('name', $request->organization_name)->first();
            if ($organization) {
                $organization_id = $organization->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organization_id,
        ]);

        $profile = new Profile();
        $profile->title = $request->title;
        $profile->organization_name = $request->organization_name;
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->zip = $request->zip;
        $user->profile()->save($profile);

        $user->assignRole(['Customer', 'Pending Admin']);


        $template = EmailTemplate::where('code', 'account-created-customer')->first();
        $subject = $template->subject;

        $body = $template->body;
        $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

        Mail::send('emails.user-registered', compact('user', 'body'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('You have registered at otoa.org');
        });

        event(new Registered($user));

        Auth::login($user);

        $check = UserEmailFree::where('email', $user->email)->where('used_at', null)->first();
        if ($check) {
            $user = auth()->user();
            $user->createOrGetStripeCustomer();
            $user->newSubscription('default', 'price_1M0As0IEmYG6U6eCCbYC3Dpa')
                // ->withCoupon('vEduZ8TI')
                ->withCoupon('ZVNa479e')
                ->add();
            $check->used_at = now();
            $check->update();
            return redirect()->route('dashboard', ['subscription' => 'started']);
        }

        // start sending notice to admin
        $content = "<p><a href='" . route('admin.users.show', $user) . "'>" . $user->name . "</a> would like organization admin permissions</p>";

        $user = User::where('email', 'office@otoa.org')->first();
        Mail::send('emails.plain', compact('user', 'content'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Organization admin requested');
        });
        // $user = User::where('email', 'jason.waddell@otoa.org')->first();
        // if ($user) {
        //     Mail::send('emails.plain', compact('user', 'content'), function ($message) use ($user) {
        //         $message->to($user->email);
        //         $message->subject('Organization admin requested');
        //     });
        // }
        // $user = User::where('email', 'rick.friedl@otoa.org')->first();
        // if ($user) {
        //     Mail::send('emails.plain', compact('user', 'content'), function ($message) use ($user) {
        //         $message->to($user->email);
        //         $message->subject('Organization admin requested');
        //     });
        // }
        // end sending notice to admin

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
