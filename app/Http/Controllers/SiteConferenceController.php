<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Page;
use App\Models\User;
use App\Models\Radio;
use App\Models\Course;
use App\Models\CourseTag;
use App\Models\Conference;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\CourseAttendee;
use App\Models\ConferenceAttendee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\VendorRegistrationSubmission;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class SiteConferenceController extends Controller
{


    public function conferences()
    {
        $conferences = Conference::where('end_date', '>=', now())->where('conference_visible', 1)->orderBy('start_date')->get();
        return view('site.conferences.index', compact('conferences'));
    }
    public function conference(Conference $conference)
    {
        if (!$conference->conference_visible) {
            abort(404);
        }

        $courses = Course::where('conference_id', $conference->id)
            ->with('parent')
            ->with('children')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->with('users:id,name')
            ->with('users.profile:id,user_id,image')
            ->with('venue:id,name,address,city,state,zip,slug')
            ->with('courseTags')
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($date) {
                return $date->start_date->format('l, F j, Y');
            });
        // dd($courses);
        foreach ($courses as $day) {
            foreach ($day as $course) {
                $course->date_display = $course->start_date->format('l, F j, Y');
                $course->start_time = $course->start_date->format('H:i');
                $course->end_time = $course->end_date->format('H:i');
                $course->filled = $course->courseAttendees->count();
                $course->closed = ($course->courseAttendees->count() >= $course->capacity) ? true : false;
                $course->disabled = $course->closed;
                $course->instructor_image = Storage::disk('s3')->url('profiles/' . ($course->user ? ($course->user->profile->image ? $course->user->profile->image : 'no-image.png') : 'no-image.png'));
            }
        }

        $courseTags = CourseTag::orderBy('name')->pluck('name', 'id');

        return view('site.conferences.show', compact('conference', 'courses', 'courseTags'));
    }



    public function courses(Conference $conference)
    {
        $courses = Course::where('conference_id', $conference->id)
            ->with('parent')
            ->with('children')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->with('users:id,name')
            ->with('users.profile:id,user_id,image')
            ->with('venue:id,name,address,city,state,zip,slug')
            ->with('courseTags')
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($date) {
                return $date->start_date->format('l, F j, Y');
            });

        return view('site.conferences.courses', compact('conference', 'courses'));
    }
    public function course(Conference $conference, Course $course)
    {
        return view('site.conferences.course', compact('conference', 'course'));
    }



    public function conferenceRegisterChoice(Conference $conference)
    {
        return view('site.conferences.register-choice', compact('conference'));
    }
    public function conferenceRegisterCivilian(Conference $conference)
    {
        auth()->user()->assignRole('Civilian');
        return redirect()->route('conference.register', $conference);
    }

    public function conferenceRegister(Conference $conference)
    {
        if (!auth()->check()) {
            return redirect()->route('conference', $conference);
        }
        Session::put('conference', $conference->id);

        $courses = Course::where('conference_id', $conference->id)
            ->with('parent')
            ->with('children')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->with('users:id,name')
            ->with('users.profile:id,user_id,image')
            ->with('venue:id,name,address,city,state,zip,slug')
            ->with('courseTags')
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($date) {
                return $date->start_date->format('l, F j, Y');
            });
        // dd($courses);
        foreach ($courses as $day) {
            foreach ($day as $course) {
                $course->date_display = $course->start_date->format('l, F j, Y');
                $course->start_time = $course->start_date->format('H:i');
                $course->end_time = $course->end_date->format('H:i');
                $course->filled = $course->courseAttendees->count();
                $course->closed = ($course->courseAttendees->count() >= $course->capacity) ? true : false;
                $course->disabled = $course->closed;
                $course->instructor_image = Storage::disk('s3')->url('profiles/' . ($course->user ? ($course->user->profile->image ? $course->user->profile->image : 'no-image.png') : 'no-image.png'));
            }
        }

        $users = null;
        if (auth()->user()) {
            if (auth()->user()->can('organization-admin')) {
                $organization = Organization::find(session()->get('organization_id'));
                $users = User::whereIn('id', $organization->primaryUsers->pluck('id'))
                    ->orWhereIn('id', $organization->users->pluck('id'))
                    ->orderBy('name')
                    ->with('profile:id,user_id,image')
                    ->get(['id', 'name', 'email']);
                $users->map(function ($item) use ($conference) {
                    $item->image = Storage::disk('s3')->url('profiles/' . ($item->profile->image ? $item->profile->image : 'no-image.png'));
                    $item->admin = $item->can('organization-admin');
                    $item->member = $item->subscribed();
                    $item->registered = $item->conferenceAttendees->where('conference_id', $conference->id)->isNotEmpty();
                    return $item;
                });
            }
        }

        $privacy_policy = Page::where('name', 'Privacy Policy')->first();
        $liability = Page::where('name', 'Liability Waiver')->first();
        $cancellation = Page::where('id', 10)->first();

        return view('site.conferences.register', [
            'privacy_policy' => $privacy_policy,
            'liability' => $liability,
            'cancellation' => $cancellation,
            'conference' => $conference,
            'courses' => $courses,
            'users' => $users,
        ]);
    }

    public function checkCourses(Request $request)
    {

        $return = null;
        $good = 0;
        $bad = 0;
        $errors = [];
        if ($request->course_ids) {
            foreach ($request->course_ids as $id) {
                $course = Course::find($id);
                if ($course->courseAttendees->count() < $course->capacity) {
                    $good++;
                } else {
                    $bad++;
                    $error = [
                        'id' => $course->id,
                        'name' => $course->name,
                        'filled' => $course->courseAttendees->count(),
                        'capacity' => $course->capacity
                    ];
                    array_push($errors, $error);
                }
            }
        }
        // return $request->all();
        return response()->json($errors);
    }

    public function conferenceRegisterPost(Conference $conference, Request $request)
    {
        if ($request->pay_type == 'invoice') {
            $attendee = ConferenceAttendee::where('conference_id', $conference->id)
                ->where('user_id', auth()->user()->can('organization-admin') ? $request->user_id : auth()->user()->id)
                ->get();

            if ($attendee->isNotEmpty()) {
                return redirect()->route('conference.register', ['conference' => $conference, 'registration' => 'found']);
            }

            $conferenceAttendee = new ConferenceAttendee();
            $conferenceAttendee->conference_id = $conference->id;
            $conferenceAttendee->user_id = auth()->user()->can('organization-admin') ? $request->user_id : auth()->user()->id;
            $conferenceAttendee->package = $request->package;
            $conferenceAttendee->pay_type = $request->pay_type;
            $conferenceAttendee->name = $request->name;
            $conferenceAttendee->email = $request->email;
            $conferenceAttendee->purchase_order = $request->purchase_order;
            $conferenceAttendee->total = $request->total;
            if (auth()->user()->can('organization-admin')) {
                $user = User::find($request->user_id);
                if (!$user->subscribed()) {
                    $conferenceAttendee->total += 30;
                }
            } else {
                if (!auth()->user()->subscribed()) {
                    $conferenceAttendee->total += 30;
                }
            }
            $conferenceAttendee->notes = $request->notes;
            $conferenceAttendee->save();


            if ($request->course_ids) {
                foreach ($request->course_ids as $course_id) {
                    $courseAttendee = new CourseAttendee();
                    $courseAttendee->course_id = $course_id;
                    $courseAttendee->user_id = auth()->user()->can('organization-admin') ? $request->user_id : auth()->user()->id;
                    $courseAttendee->notes = $request->notes;
                    $conferenceAttendee->courseAttendees()->save($courseAttendee);
                }
            }

            $email = $conferenceAttendee->user->email;
            $subject = "You have been registered for the " . $conferenceAttendee->conference->name;
            Mail::send('emails.conference-registered', compact('conferenceAttendee'), function ($send) use ($email, $subject) {
                $send->to($email)->subject($subject);
            });

            return redirect()->route('conference.register', ['conference' => $conference, 'registration' => 'complete'])->with('registered_user', $conferenceAttendee->user->name);
        }

        if ($request->pay_type == 'credit_card') {
            $cc = $request->cc;
            $cc = str_replace(' ', '', $cc);

            $nameArray = explode(' ', $request->card_holder_name);
            $card_first_name = $nameArray[0];
            array_shift($nameArray);
            $card_last_name = implode(' ', $nameArray);

            // dd($request->all());
            $user = auth()->user();
            $paymentMethod = $request->input('payment_method');
            $amount = $request->total;
            $description = $conference->name . ' - ' . $request->package;



            /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(config('site.merchant_login_id'));
            $merchantAuthentication->setTransactionKey(config('site.merchant_transaction_key'));

            // Set the transaction's refId
            $refId = 'ref' . time();

            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cc);
            $creditCard->setExpirationDate($request->year . '-' . $request->month);
            // $creditCard->setCardCode("123");

            // Add the payment data to a paymentType object
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            // Create order information
            $order = new AnetAPI\OrderType();
            // $order->setInvoiceNumber("10101");
            $order->setDescription($description);

            // Set the customer's Bill To address
            $customerAddress = new AnetAPI\CustomerAddressType();
            $customerAddress->setFirstName($card_first_name);
            $customerAddress->setLastName($card_last_name);
            // $customerAddress->setCompany("Souveniropolis");
            // $customerAddress->setAddress("14 Main Street");
            // $customerAddress->setCity("Pecan Springs");
            // $customerAddress->setState("TX");
            // $customerAddress->setZip("44628");
            // $customerAddress->setCountry("USA");

            // Set the customer's identifying information
            // $customerData = new AnetAPI\CustomerDataType();
            // $customerData->setType("individual");
            // $customerData->setId("99999456654");
            // $customerData->setEmail("EllenJohnson@example.com");

            // Add values for transaction settings
            $duplicateWindowSetting = new AnetAPI\SettingType();
            $duplicateWindowSetting->setSettingName("duplicateWindow");
            $duplicateWindowSetting->setSettingValue("60");

            // Add some merchant defined fields. These fields won't be stored with the transaction,
            // but will be echoed back in the response.
            // $merchantDefinedField1 = new AnetAPI\UserFieldType();
            // $merchantDefinedField1->setName("customerLoyaltyNum");
            // $merchantDefinedField1->setValue("1128836273");

            // $merchantDefinedField2 = new AnetAPI\UserFieldType();
            // $merchantDefinedField2->setName("favoriteColor");
            // $merchantDefinedField2->setValue("blue");

            // Create a TransactionRequestType object and add the previous objects to it
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction");
            $transactionRequestType->setAmount($amount);
            $transactionRequestType->setOrder($order);
            $transactionRequestType->setPayment($paymentOne);
            $transactionRequestType->setBillTo($customerAddress);
            // $transactionRequestType->setCustomer($customerData);
            $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
            // $transactionRequestType->addToUserFields($merchantDefinedField1);
            // $transactionRequestType->addToUserFields($merchantDefinedField2);

            // Assemble the complete transaction request
            $trequest = new AnetAPI\CreateTransactionRequest();
            $trequest->setMerchantAuthentication($merchantAuthentication);
            $trequest->setRefId($refId);
            $trequest->setTransactionRequest($transactionRequestType);

            // Create the controller and get the response
            $controller = new AnetController\CreateTransactionController($trequest);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);


            if ($response != null) {
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == "Ok") {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();

                    // if ($tresponse != null && $tresponse->getMessages() != null) {
                    //     echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
                    //     echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
                    //     echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
                    //     echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
                    //     echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
                    // } else {
                    //     echo "Transaction Failed \n";
                    //     if ($tresponse->getErrors() != null) {
                    //         echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                    //         echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                    //     }
                    // }
                    // Or, print errors if the API request wasn't successful
                } else {
                    echo "Transaction Failed \n";
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                        echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                    } else {
                        echo " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                        echo " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
                    }
                }
            } else {
                echo  "No response returned \n";
            }



            // dd($request->all());
            // $user = auth()->user();
            // $paymentMethod = $request->input('payment_method');
            // $price = $request->total * 100;
            // $description = $conference->name . ' - ' . $request->package;

            // // dd($description);

            // $user->createOrGetStripeCustomer();
            // $user->addPaymentMethod($paymentMethod);

            // try {
            //     $stripeCharge = $user->charge(
            //         $price,
            //         $paymentMethod,
            //         [
            //             'description' => $description,
            //         ]
            //     );
            // } catch (Exception $e) {
            //     return back();
            // }
            // dd($stripeCharge);

            $conferenceAttendee = new ConferenceAttendee();
            $conferenceAttendee->conference_id = $conference->id;
            $conferenceAttendee->user_id = auth()->user()->can('organization-admin') ? $request->user_id : auth()->user()->id;
            $conferenceAttendee->package = $request->package;
            $conferenceAttendee->pay_type = $request->pay_type;
            $conferenceAttendee->name = $request->card_holder_name;
            // $conferenceAttendee->email = $request->email;
            $conferenceAttendee->purchase_order = $request->purchase_order;
            $conferenceAttendee->total = $request->total;
            $conferenceAttendee->notes = $request->notes;
            $conferenceAttendee->pay_type = $request->pay_type;
            $conferenceAttendee->stripe_id = $tresponse->getTransId();
            // $conferenceAttendee->stripe_status = $stripeCharge->status;
            $conferenceAttendee->paid = 1;
            $conferenceAttendee->save();


            if ($request->course_ids) {
                foreach ($request->course_ids as $course_id) {
                    $courseAttendee = new CourseAttendee();
                    $courseAttendee->course_id = $course_id;
                    $courseAttendee->user_id = auth()->user()->can('organization-admin') ? $request->user_id : auth()->user()->id;
                    $courseAttendee->notes = $request->notes;
                    $conferenceAttendee->courseAttendees()->save($courseAttendee);
                }
            }

            $email = $conferenceAttendee->user->email;
            $subject = "You have been registered for the " . $conferenceAttendee->conference->name;
            Mail::send('emails.conference-registered', compact('conferenceAttendee'), function ($send) use ($email, $subject) {
                $send->to($email)->subject($subject);
            });

            return redirect()->route('conference.register', ['conference' => $conference, 'registration' => 'complete']);
        }

        return redirect('dashboard');



        // dd($request->all());
        // return redirect()->route('trainingCourse', [$slug, $trainingCourse])->with('success', 'Training Registered');
    }



    public function conferenceRegisterGeneral(Conference $conference)
    {
        $privacy_policy = Page::where('name', 'Privacy Policy')->first();
        $liability = Page::where('name', 'Liability Waiver')->first();
        $cancellation = Page::where('id', 10)->first();

        return view('site.conferences.register-general', compact('conference', 'privacy_policy', 'liability', 'cancellation'));
    }

    public function conferenceRegisterGeneralPost(Request $request, Conference $conference)
    {
        $conferenceAttendee = new ConferenceAttendee();
        $conferenceAttendee->conference_id = $conference->id;
        $conferenceAttendee->user_id = auth()->user()->id;
        $conferenceAttendee->package = 'General Session';
        $conferenceAttendee->total = 0;
        $conferenceAttendee->save();


        $courseAttendee = new CourseAttendee();
        $courseAttendee->course_id = $conference->free_course_id;
        $courseAttendee->user_id = auth()->user()->id;
        $conferenceAttendee->courseAttendees()->save($courseAttendee);

        return redirect()->back()->with('success', 'You have been registered for the General Session');
    }


    public function vendors(Conference $conference)
    {
        // $vendors = VendorRegistrationSubmission::where('conference_id', $conference->id)
        //     ->where('public', 1)
        //     ->orderBy('sponsorship_price', 'DESC')
        //     // ->orderBy('company_name', 'ASC')
        //     ->with([
        //         'organization' => function ($query) {
        //             $query->orderBy('name', 'ASC');
        //         }
        //     ])
        //     ->get()
        //     ->groupBy('sponsorship')
        //     ->sortBy('organization.name');

        $vendors = VendorRegistrationSubmission::where('conference_id', $conference->id)
            ->where('public', 1)
            ->with([
                'organization' => function ($query) {
                    $query->orderBy('name', 'ASC');
                }
            ])
            ->get()->sortBy('organization.name');

        // dd(VendorRegistrationSubmission::where('conference_id', $conference->id)->get('sponsorship')->toArray());
        $radios = Radio::where('field', 'sponsorship')
            ->whereIn('value', VendorRegistrationSubmission::where('conference_id', $conference->id)->where('public', 1)->get('sponsorship')->toArray())
            ->orderBy('order', 'DESC')->get();


        // dd($vendors);
        return view('site.conferences.vendors', compact('conference', 'vendors', 'radios'));
    }
    public function vendor(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        $organization = $vendorRegistrationSubmission->organization;
        // dd($vendorRegistrationSubmission);

        return view('site.conferences.vendor', compact('conference', 'organization'));
    }


    public function sponsorships(Conference $conference)
    {
        $sponsorships = Page::where('name', 'Conference Sponsorships')->first();
        return view('site.conferences.sponsorships', compact('conference', 'sponsorships'));
    }

    public function conferenceInstructorInformation(Conference $conference)
    {
        $information = Page::find(15);
        return view('site.conferences.conference-instructor-information', compact('conference', 'information'));
    }
    public function vendorInformation(Conference $conference)
    {
        $information = Page::where('name', 'Exhibitor Information')->first();
        return view('site.conferences.vendor-information', compact('conference', 'information'));
    }
    public function shipping(Conference $conference)
    {
        $information = Page::where('slug', 'kalahari-shipping-and-receiving')->first();
        return view('site.conferences.shipping', compact('conference', 'information'));
    }
}
