<?php

namespace App\Http\Controllers\Store;

use App\Helpers\InvisionAPI;
use App\Http\Controllers\Controller;
use App\Models\CreditPackage;
use App\Models\CreditPayment;
use App\Models\Store\UserCredit;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadeRequest;
use PayPal\Api\Amount;
use PayPal\Api\InputFields;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\WebProfile;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Session;
use URL;

class PaypalController extends Controller
{
    protected $forumInstance;
    private $apiContext;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
        // Main configuration in constructor
        $paypalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret'])
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function checkout(HttpRequest $request)
    {
        $member = $this->forumInstance->getCachedMember();
        $username = $member->getName();
        $creditPackageModel = CreditPackage::where('id', $request->input('credit_id'))->firstOrFail();

        // We initialize the payer object and set the payment method to PayPal
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // We insert a new order in the order table with the 'initialised' status
        $creditPayment = new CreditPayment();
        $creditPayment->username = $username;
        $creditPayment->email = $member->getEmail();
        $creditPayment->item_name = $creditPackageModel->getFullCreditsAmount('paypal') . ' Credits';
        $creditPayment->paid = $creditPackageModel->getDiscountedPrice();
        $creditPayment->credit_Amount = $creditPackageModel->getFullCreditsAmount('paypal');
        $creditPayment->status = 'Initialised';
        $creditPayment->client_ip = $request->ip();
        $creditPayment->cvc_pass = 'paypal';
        $creditPayment->zip_pass = 'paypal';
        $creditPayment->address_pass = 'paypal';
        $creditPayment->live_mode = 1;
        $creditPayment->paid_on = Carbon::now();
        $creditPayment->save();
        // We need to update the order if the payment is complete, so we save it to the session
        Session::put('creditPaymentId', $creditPayment->getKey());

        $items[] = (new Item())
            ->setName($creditPackageModel->getFullCreditsAmount('paypal') . ' Zenyte Credits')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($creditPackageModel->getDiscountedPrice());

        // We create a new item list and assign the item to it
        $itemList = new ItemList();
        $itemList->setItems($items);

        // Disable all irrelevant PayPal aspects in payment
        $inputFields = new InputFields();
        $inputFields->setAllowNote(true)
            ->setNoShipping(1)
            ->setAddressOverride(0);

        $webProfile = new WebProfile();
        $webProfile->setName(uniqid())
            ->setInputFields($inputFields)
            ->setTemporary(true);

        $createProfile = $webProfile->create($this->apiContext);

        // We get the total price of the item
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($creditPackageModel->getDiscountedPrice());

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction
            ->setItemList($itemList)
            ->setDescription('A payment for ' . $creditPackageModel->getFullCreditsAmount('paypal') . ' credits credited to your Zenyte account with the following username: ' . $username);

        $redirectURLs = new RedirectUrls();
        $redirectURLs->setReturnUrl(URL::to('status'))
            ->setCancelUrl(URL::to('store'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectURLs)
            ->setTransactions([$transaction]);
        $payment->setExperienceProfileId($createProfile->getId());
        $payment->create($this->apiContext);

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectURL = $link->getHref();
                break;
            }
        }

        // We store the payment ID into the session
        Session::put('paypalPaymentId', $payment->getId());

        if (isset($redirectURL)) {
            return Redirect::away($redirectURL);
        }

        //If we've got here something went wrong so let's just abort
        return abort(404);
    }

    public function getPaymentStatus()
    {
        $paymentId = Session::get('paypalPaymentId');

        //Our credit payment model ID
        $creditPaymentId = Session::get('creditPaymentId');

        // We now erase the payment ID from the session to avoid fraud
        Session::forget('paypalPaymentId');

        // If the payer ID or token isn't set, there was a corrupt response and instantly abort
        if (empty(FacadeRequest::get('PayerID')) || empty(FacadeRequest::get('token'))) {
            return Redirect::to('/')->with('error', 'There was a problem processing your payment. Please contact support.');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(FacadeRequest::get('PayerID'));

        $result = $payment->execute($execution, $this->apiContext);
        // Payment is processing but may still fail due e.g to insufficient funds
        $creditPayment = CreditPayment::find($creditPaymentId);
        $creditPayment->status = 'processing';

        if ($result->getState() == 'approved') {
            $transactions = $result->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            // We also update the order status
            $isCheck = false;
            if ($sale->getPaymentMode() == "ECHECK") { //We want to accept e-cheques but we want to manually approve them, so set the status to pending
                $isCheck = true;
                $creditPayment->status = 'Pending';
            } else {
                $creditPayment->status = 'Completed';
            }
            $creditPayment->save();
            if ($isCheck) {
                Session::flash('paymentComplete', 'Thank you for your purchase! Your credits will be sent to your account when your E-Cheque clears.');
            } else {
                Session::flash('paymentComplete', 'Thank you for your purchase! Your credits have now been added to your account successfully!');
            }
            $member = $this->forumInstance->loadMember($creditPayment->username);
            $existingCredit = UserCredit::where('user_id', $member->getId())->first();
            if ($existingCredit == null) {
                $existingCredit = UserCredit::createNewCredit($member->getId(), $creditPayment->username);
            }
            $existingCredit->credits += $creditPayment->credit_amount;
            $existingCredit->total_credits += $creditPayment->credit_amount;
            $existingCredit->save();
            return redirect(route('store'));
        }
        return Redirect::to('/')->with('error', 'There was a problem processing your payment. Please contact support.');
    }
}