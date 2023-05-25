<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Page;
use App\Models\User;
use App\Models\Training;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;
use App\Models\TrainingWaitlist;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingCourseAttendee;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class SiteTrainingController extends Controller
{
    public function calendar()
    {
        $trainingCourses = TrainingCourse::where('visible', 1)
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->get();
        return view('site.trainings.calendar', compact('trainingCourses'));
    }
    public function trainings()
    {
        $trainings = Training::where('active', 1)->orderBy('order')->get();
        return view('site.trainings.index', compact('trainings'));
    }
    public function training($slug)
    {
        $training = Training::where('slug', $slug)->where('active', 1)->first();
        if ($training == null) {
            abort(404);
        }
        return view('site.trainings.show', compact('training'));
    }

    public function trainingCourse($slug, TrainingCourse $trainingCourse)
    {
        // $course = TrainingCourse::where('id', $id)->where('active', 1)->first();
        // if ($course == null) {
        //     abort(404);
        // }
        return view('site.training-courses.show', compact('trainingCourse'));
    }
    public function trainingCourseRegister($slug, TrainingCourse $trainingCourse)
    {
        // $course = TrainingCourse::where('id', $id)->where('active', 1)->first();
        // if ($course == null) {
        //     abort(404);
        // }
        Session::put('training', $trainingCourse->id);

        $privacy_policy = Page::where('name', 'Privacy Policy')->first();
        $liability = Page::where('name', 'Liability Waiver')->first();
        $cancellation = Page::where('id', 11)->first();

        $users = null;
        if (auth()->user()) {
            if (auth()->user()->can('organization-admin')) {
                if (auth()->user()->organization) {
                    $organization = Organization::find(session()->get('organization_id'));
                    $users = User::whereIn('id', $organization->primaryUsers->pluck('id'))
                        ->orWhereIn('id', $organization->users->pluck('id'))
                        ->orderBy('name')
                        ->with('profile:id,user_id,image')
                        ->get(['id', 'name', 'email']);
                    $users->map(function ($item) use ($trainingCourse) {
                        $item->image = Storage::disk('s3')->url('profiles/' . ($item->profile->image ? $item->profile->image : 'no-image.png'));
                        $item->admin = $item->can('organization-admin');
                        $item->member = $item->subscribed();
                        $item->registered = $item->trainingCourseAttendees->where('training_course_id', $trainingCourse->id)->isNotEmpty();
                        return $item;
                    });
                }
            }
        }

        return view('site.training-courses.register', [
            'trainingCourse' => $trainingCourse,
            'privacy_policy' => $privacy_policy,
            'cancellation' => $cancellation,
            'liability' => $liability,
            'users' => $users,
        ]);
    }

    public function trainingCourseRegisterPost($slug, TrainingCourse $trainingCourse, Request $request)
    {
        if ($request->pay_type == 'invoice') {

            if (auth()->user()->can('organization-admin')) {
                foreach ($request->user_id as $user_id) {
                    $user = User::find($user_id);
                    $attendee = new TrainingCourseAttendee();
                    $attendee->training_course_id = $trainingCourse->id;
                    $attendee->user_id = $user_id;
                    $attendee->total = $trainingCourse->price;
                    if (!$user->subscribed()) {
                        $attendee->total = $trainingCourse->price + 30;
                    }
                    $attendee->pay_type = $request->pay_type;
                    $attendee->name = $request->name;
                    $attendee->email = $request->email;
                    $attendee->purchase_order = $request->purchase_order;
                    $attendee->notes = $request->notes;
                    $attendee->save();
                }
            } else {
                $attendee = new TrainingCourseAttendee();
                $attendee->training_course_id = $trainingCourse->id;
                $attendee->user_id = auth()->user()->id;
                $attendee->total = $trainingCourse->price;
                if (!auth()->user()->subscribed()) {
                    $attendee->total = $trainingCourse->price + 30;
                }
                $attendee->pay_type = $request->pay_type;
                $attendee->name = $request->name;
                $attendee->email = $request->email;
                $attendee->purchase_order = $request->purchase_order;
                $attendee->notes = $request->notes;
                $attendee->save();
            }

            return redirect('dashboard')->with('success', 'You have been registered for ' . $trainingCourse->training->name . '.');
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
            $amount = $trainingCourse->price;
            $description = $trainingCourse->training->name . ' ' . $trainingCourse->start_date->format('m/d/Y');


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
            $order->setInvoiceNumber("10101");
            $order->setDescription("Golf Shirts");

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

            // return $response;






            // dd($description);

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

            $attendee = new TrainingCourseAttendee();
            $attendee->training_course_id = $trainingCourse->id;
            $attendee->user_id = auth()->user()->id;
            $attendee->total = $trainingCourse->price;
            $attendee->pay_type = $request->pay_type;
            $attendee->stripe_id = $tresponse->getTransId();
            // $attendee->stripe_status = $stripeCharge->status;
            $attendee->notes = $request->notes;
            $attendee->paid = 1;
            $attendee->save();

            return redirect('dashboard')->with('success', 'You have been registered for ' . $trainingCourse->training->name . '.');
        }

        return redirect('dashboard');



        // dd($request->all());
        return redirect()->route('trainingCourse', [$slug, $trainingCourse])->with('success', 'Training Registered');
    }

    public function trainingCourseWaitlistPost(Training $training, TrainingCourse $trainingCourse, Request $request)
    {
        $waitlist = new TrainingWaitlist();
        $waitlist->training_course_id = $trainingCourse->id;
        $waitlist->user_id = auth()->user()->id;
        $waitlist->comments = $request->comments;
        $waitlist->save();

        return back()->with('success', 'You have been added to the waitlist for ' . $trainingCourse->training->name . '.');
    }
}
