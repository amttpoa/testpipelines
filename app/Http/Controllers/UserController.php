<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\Note;
use App\Models\Plan;
use App\Models\User;
use App\Models\Expense;
use App\Models\UserNote;
use App\Models\EmailSent;
use Illuminate\Support\Arr;
use App\Exports\UsersExport;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Models\EmailTemplate;
use App\Models\UserEmailFree;
use App\Jobs\SendPlainEmailJob;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AuthorizeSubscription;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Password;
use Illuminate\Notifications\Messages\MailMessage;

class UserController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }


    public function dashboard()
    {
        // $data = User::with('roles')->orderBy('name', 'ASC')->paginate(50);

        return view('dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'organization_id' => ''
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $user->profile()->create();


        $user->profile->title = $request->title;
        $user->profile->birthday = $request->birthday;
        $user->profile->phone = $request->phone;
        $user->profile->update();


        if ($request->organization_ids) {
            $organization_ids = array_diff($request->organization_ids, [0]);
            $user->organizations()->sync($organization_ids);
        }


        if ($request->send_email == 'send') {
            // $user = auth()->user();
            $subject = "An account has been created for you at TTPOA.org";
            $email = $user->email;

            Mail::send('emails.new-user-added-by-admin', compact('user'), function ($send) use ($email, $subject) {
                $send->to($email)->subject($subject);
            });
        }



        // $credentials = ['email' => $user->email];
        // // $response = Password::sendResetLink($credentials, function (Message $message) {
        // //     $message->subject($this->getEmailSubject());
        // // });
        // // dd($user);
        // $response = Password::sendResetLink($credentials);
        // // dd($response);

        // switch ($response) {
        //     case Password::RESET_LINK_SENT:
        //         return redirect()->back()->with('success', trans($response));
        //     case Password::INVALID_USER:
        //         return redirect()->back()->withErrors(['email' => trans($response)]);
        // }



        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $activities = Activity::where('causer_type', 'App\Models\User')
            ->where(function ($q) use ($user) {
                $q->where(function ($q2) use ($user) {
                    $q2->where('subject_type', 'App\Models\User')
                        ->where('subject_id', $user->id);
                })->orWhere(function ($q2) use ($user) {
                    $q2->where('subject_type', 'App\Models\Profile')
                        ->where('subject_id', $user->profile->id);
                });
            })
            ->orderBy('created_at', 'desc')->get();

        // dd($activities);
        $plans = Plan::all();
        $free = UserEmailFree::where('email', $user->email)->first();

        return view('users.show', compact('user', 'activities', 'plans', 'free'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } else {
            $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();
        }
        $userRole = $user->roles->pluck('name', 'name')->all();
        $organizations = Organization::pluck('name', 'id')->all();

        return view('users.edit', compact('user', 'roles', 'userRole', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->input('roles'));

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'organization_id' => ''
        ]);


        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));


        $profile = $user->profile;
        $profile->title = $request->title;
        $profile->birthday = $request->birthday;
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->zip = $request->zip;
        $profile->bio = $request->bio;
        if ($request->delete_image == 'delete') {
            $profile->image = null;
        }
        $profile->update();


        if ($request->organization_ids) {
            $organization_ids = array_diff($request->organization_ids, [0]);
            $user->organizations()->sync($organization_ids);
        }


        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }



    public function updatePassword(Request $request, User $user)
    {
        // $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);

        $user->update();

        return response()->json(['user' => $user->name]);
    }

    public function sendResetEmail(User $user)
    {
        $credentials = ['email' => $user->email];
        // $response = Password::sendResetLink($credentials, function (Message $message) {
        //     $message->subject($this->getEmailSubject());
        // });
        // dd($user);
        $response = Password::sendResetLink($credentials);
        // dd($response);

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('success', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function sendEmail(Request $request, User $user)
    {
        $email = $user->email;
        $subject = $request->subject;
        $content = $request->content;

        $content = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $content);

        $sig = $request->sig;
        $sig_user = auth()->user();

        Mail::send('emails.plain', compact('user', 'content', 'sig', 'sig_user'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });

        return back()->with('success', 'Email Sent');
    }

    public function subscribe(Request $request, User $user)
    {

        $subscription = new AuthorizeSubscription;
        $subscription->user_id = $user->id;
        $subscription->authorize_plan = 'Individual Membership';
        $subscription->ends_at = now()->addYears(1);
        $subscription->save();

        $note = new Note;
        $note->subject_type = 'App\Models\User';
        $note->subject_id = $user->id;
        $note->user_id = auth()->user()->id;
        $note->note = 'Subscription given';
        $note->save();

        $email = $user->email;

        $template = EmailTemplate::where('code', 'subscription-started')->first();
        $subject = $template->subject;

        $content = $template->body;
        $content = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $content);

        Mail::send('emails.plain', compact('user', 'content'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });

        return redirect()->back()->with('success', 'User given one year subscription');
    }

    public function cancel(Request $request, User $user)
    {
        $user->createOrGetStripeCustomer();
        $user->subscription('default')->cancelNow();
        return back()->with('success', 'User subscription cancelled');
    }


    public function markPaid(Request $request, User $user, $id)
    {
        $stripe = new \Stripe\StripeClient(
            config('site.stripe_secret')
        );
        $stripe->invoices->pay(
            $id,
            ['paid_out_of_band' => true]
        );
        return back()->with('success', 'Invoice marked as paid');
    }


    public function storenote(Request $request)
    {
        $userNote = new UserNote();
        $userNote->note_user_id = $request->input('user_id');
        $userNote->user_id = auth()->user()->id;
        $userNote->note = $request->input('new_note');
        $userNote->save();

        $userNote->created_at_formatted = $userNote->created_at->format('F jS Y h:i A') . ' (' . $userNote->created_at->diffForHumans() . ')';
        $userNote->user_image = Storage::disk('s3')->url('profiles/' . ($userNote->user->profile->image ? $userNote->user->profile->image : 'no-image.png'));

        return response()->json($userNote);
    }


    public function export(Request $request)
    {
        $file = 'Users-' . now()->format('m-d-Y') . '.xlsx';
        return Excel::download(new UsersExport($request), $file);
    }


    public function sendEmails(Request $request)
    {
        $users = User::role('Customer')->get();

        $total = 0;
        foreach ($users as $user) {
            if ($user->hasExactRoles('Customer')) {
                $total++;
            }
        }
        // dd($total);
        // dd($users);
        // dd($users->hasExactRoles('Customer'));
        $tos = [
            'Customers Only' => 'Customers Only - ' . $total . ' Users',
            'Super Admin' => 'Super Admin',
        ];
        $sent = EmailSent::where('subject_type', 'App\Models\User')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('users.send-emails', compact('tos', 'sent', 'request'));
    }

    public function sendEmailsPost(Request $request)
    {
        $message = $request->message;
        $subject = $request->subject;
        $to = $request->to;
        $sig = $request->sig;
        $count = 0;

        if ($to == 'Customers Only') {
            $users = User::role('Customer')->get();
            foreach ($users as $user) {
                if ($user->hasExactRoles('Customer')) {
                    // dd($user);
                    $sig_user = auth()->user();
                    $job = new SendPlainEmailJob($user, $subject, $message, $sig, $sig_user);
                    dispatch($job);
                    $count++;
                }
            }
        }
        if ($to == 'Super Admin') {
            $users = User::role('Super Admin')->get();
            foreach ($users as $user) {
                $sig_user = auth()->user();
                $job = new SendPlainEmailJob($user, $subject, $message, $sig, $sig_user);
                dispatch($job);
                $count++;
            }
        }


        $sent = new EmailSent();
        $sent->subject_type = "App\Models\User";
        $sent->to = $to;
        $sent->subject = $subject;
        $sent->message = $message;
        $sent->sent = $count;
        $sent->save();

        return redirect()->back()->with('success', 'Emails sent');
    }

    public function loginAs(User $user)
    {
        if (auth()->user()->can('full-access')) {
            Session::put('backto', auth()->user()->id);
            // Auth::loginUsingId(157);
            Auth::login($user);
            if (auth()->user()->organization) {
                session()->put('organization_id', auth()->user()->organization->id);
            }
        }
        return redirect()->route('dashboard');
    }
    public function backToMe()
    {
        $user = auth()->user();
        Auth::loginUsingId(Session::get('backto'));
        Session::forget('backto');

        if (auth()->user()->organization) {
            session()->put('organization_id', auth()->user()->organization->id);
        }

        return redirect()->route('admin.users.show', $user)->with('success', 'Welcome back');
    }
}
