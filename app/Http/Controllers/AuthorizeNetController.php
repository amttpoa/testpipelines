<?php

namespace App\Http\Controllers;

use DateTime;

use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use net\authorize\api\contract\v1\MerchantAuthenticationType;

class AuthorizeNetController extends Controller
{
    public function createSubscription()
    {

        /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('site.merchant_login_id'));
        $merchantAuthentication->setTransactionKey(config('site.merchant_transaction_key'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName("Standard subscription");

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength(12);
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(now());
        $paymentSchedule->setTotalOccurrences("9999");
        $paymentSchedule->setTrialOccurrences("0");

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount("30.00");
        $subscription->setTrialAmount("0.00");

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber("4111111111111111");
        $creditCard->setExpirationDate("2037-12");

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);
        $subscription->setPayment($payment);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber(rand(100000, 999999));
        $order->setDescription("Standard membership");
        $subscription->setOrder($order);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName("John");
        $billTo->setLastName("Smith");

        $subscription->setBillTo($billTo);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);

        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
        }

        return $response;
    }

    function getSubscription()
    {
        $subscriptionId = '8793507';
        /* Create a merchantAuthenticationType object with authentication details
         retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('site.merchant_login_id'));
        $merchantAuthentication->setTransactionKey(config('site.merchant_transaction_key'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Creating the API Request with required parameters
        $request = new AnetAPI\ARBGetSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);
        $request->setIncludeTransactions(true);

        // Controller
        $controller = new AnetController\ARBGetSubscriptionController($request);

        // Getting the response
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        // dd($response->getSubscription());
        if ($response != null) {
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Success
                echo "SUCCESS: GetSubscription:" . "\n";
                // Displaying the details
                echo "Subscription Name: " . $response->getSubscription()->getName() . "\n";
                echo "Subscription amount: " . $response->getSubscription()->getAmount() . "\n";
                echo "Subscription status: " . $response->getSubscription()->getStatus() . "\n";
                echo "Subscription Description: " . $response->getSubscription()->getProfile()->getDescription() . "\n";
                echo "Customer Profile ID: " .  $response->getSubscription()->getProfile()->getCustomerProfileId() . "\n";
                echo "Customer payment Profile ID: " . $response->getSubscription()->getProfile()->getPaymentProfile()->getCustomerPaymentProfileId() . "\n";
                $transactions = $response->getSubscription()->getArbTransactions();
                if ($transactions != null) {
                    foreach ($transactions as $transaction) {
                        echo "Transaction ID : " . $transaction->getTransId() . " -- " . $transaction->getResponse() . " -- Pay Number : " . $transaction->getPayNum() . "\n";
                    }
                }
            } else {
                // Error
                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            }
        } else {
            // Failed to get response
            echo "Null Response Error";
        }

        return $response;
    }
}
