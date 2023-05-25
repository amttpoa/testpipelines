<?php

namespace App\Http\Controllers;

// require_once('../vendor/autoload.php');

use \Stripe\Stripe;
use App\Models\Plan;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Http\Controllers\Controller;
use App\Models\AuthorizeSubscription;
use Illuminate\Support\Facades\Auth;
use net\authorize\api\contract\v1\ARBSubscriptionType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\PaymentScheduleType\IntervalAType;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        // $plans = $this->retrievePlans();
        $plans = Plan::all();
        $user = Auth::user();

        return view('site.dashboard.subscriptions.create', [
            'user' => $user,
            'plans' => $plans
        ]);
    }
    public function store(Request $request)
    {
        $cc = $request->cc;
        $cc = str_replace(' ', '', $cc);

        $plan_id = $request->plan;

        $plan = Plan::find($plan_id);


        $nameArray = explode(' ', $request->name);
        $card_first_name = $nameArray[0];
        array_shift($nameArray);
        $card_last_name = implode(' ', $nameArray);

        // dd($cc);
        /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
        $merchantAuthentication = new MerchantAuthenticationType();
        $merchantAuthentication->setName(config('site.merchant_login_id'));
        $merchantAuthentication->setTransactionKey(config('site.merchant_transaction_key'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new ARBSubscriptionType();
        $subscription->setName($plan->name);

        $interval = new IntervalAType();
        $interval->setLength(12);
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(now());
        $paymentSchedule->setTotalOccurrences("9999");
        $paymentSchedule->setTrialOccurrences("0");

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($plan->price);
        $subscription->setTrialAmount("0.00");

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cc);
        $creditCard->setExpirationDate($request->year . '-' . $request->month);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);
        $subscription->setPayment($payment);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber(rand(100000, 999999));
        $order->setDescription($plan->name);
        $subscription->setOrder($order);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($card_first_name);
        $billTo->setLastName($card_last_name);

        $subscription->setBillTo($billTo);

        $anetRequest = new AnetAPI\ARBCreateSubscriptionRequest();
        $anetRequest->setmerchantAuthentication($merchantAuthentication);
        $anetRequest->setRefId($refId);
        $anetRequest->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($anetRequest);

        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        // dd($response);
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            // echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";

            $subscription = new AuthorizeSubscription;
            $subscription->user_id = auth()->user()->id;
            $subscription->name = $request->name;
            $subscription->authorize_id = $response->getSubscriptionId();
            $subscription->authorize_payment_id = $response->getProfile()->getCustomerProfileId();
            $subscription->authorize_plan = $plan->name;
            $subscription->metadata = null;
            $subscription->quantity = 1;
            $subscription->price = $plan->price;
            $subscription->save();
        } else {
            // echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            return redirect()->back()->with('error', $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText());
        }

        // return $response;




        // dd($request->email);

        // if ($request->pay_type == 'code') {
        //     if ($request->code == 'givemeafreesub') {
        //         $user = auth()->user();

        //         $user->createOrGetStripeCustomer();
        //         // $user->newSubscription('default', 'price_1LPgSzCh7AUlZv8XR90BuZVa')->add();

        //         $user->newSubscription('default', $request->plan)
        //             // ->withCoupon('NEWWEBSITE2022')
        //             ->withCoupon('ZVNa479e')
        //             ->add();
        //     } else {
        //         return back()->withErrors(['message' => 'Invalid Code']);
        //     }
        // } elseif ($request->pay_type == 'invoice') {

        //     $user = auth()->user();
        //     $user->createOrGetStripeCustomer();

        //     $subscription = $user->newSubscription('default', $request->plan)->createAndSendInvoice(['email' => $request->email], [
        //         'days_until_due' => 30,
        //         'metadata' => ['note' => 'send to ' . $request->email]
        //     ]);

        //     // dd($subscription);

        //     $subscribe = new Subscribe;
        //     $subscribe->subscription_id = $subscription->id;
        //     $subscribe->user_id = auth()->user()->id;
        //     $subscribe->plan = $request->plan;
        //     $subscribe->email = $request->email;
        //     $subscribe->save();

        //     return redirect()->route('dashboard')->with('subscription', 'You have started your subsciption');
        //     // return back()->withErrors(['message' => 'Invoice']);
        // } else {

        // $user = Auth::user();
        // $paymentMethod = $request->input('payment_method');
        // $user->createOrGetStripeCustomer();
        // $user->addPaymentMethod($paymentMethod);
        // $plan = $request->input('plan');

        // try {
        //     $subscription = $user->newSubscription('default', $plan)->create($paymentMethod, [
        //         'email' => $user->email
        //     ]);
        // } catch (\Exception $e) {
        //     return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        // }

        // $subscribe = new Subscribe;
        // $subscribe->subscription_id = $subscription->id;
        // $subscribe->user_id = auth()->user()->id;
        // $subscribe->plan = $request->plan;
        // $subscribe->name = $request->name;
        // $subscribe->payment_method = $paymentMethod;
        // $subscribe->save();

        return redirect()->route('dashboard')->with('subscription', 'You have started your subsciption');
        // }

        return redirect('dashboard');
    }
}
