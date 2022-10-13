<?php

namespace App\Http\Controllers\Store;

use App\Helpers\InvisionAPI;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CreditPayment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Store\UserCredit;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }
    /**
     * Displays our account page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Seperate functions in checkout controller for payment methods
        //Abstract everything out so we can add more stuff in future
        //Give ironmen symbol on frontend
        //Give quantities on frontend without having to view description
        //https://discordapp.com/channels/702291575694295060/730155243027038340/747530012818800641

        //Declare our relevant variables
        $member = $this->forumInstance->getCachedMember();
        $memberName = $member->getName();
        $totalDonated = CreditPayment::where('username', $memberName)->sum('paid');

        return view('store.index', [
            'categories' => Category::all(),
            'featuredProducts' => Product::where('is_featured', 1)->where('visible', 1)->get(),
            'credits' => $this->getOrMakeCredits($member->getId(), $memberName),
            'totalDonated' => $totalDonated,
        ]);
    }

    public function getOrMakeCredits($userid, $userName)
    {
        $amount = UserCredit::getCreditAmount($userid, $userName); //Returns false if we don't have a credit
        if($amount === false) {
            $credit = UserCredit::createNewCredit($userid, $userName);
            $amount = UserCredit::getCreditAmount($userid, $userName);
        }
        return $amount;
    }

    public function emptyCart()
    {
        Cart::destroy();
        return response('Cart Emptied Successfully', 200);
    }

    public function getBondAmountInCart()
    {
        $bondAmount = 0;
        Cart::content()->map(function($item) use($bondAmount) {
            $product = Product::where('id', $item->id)->firstOrFail();
            if($product->bond_amount) {
                $bondAmount += $product->bond_amount;
            }
            return $bondAmount;
        });
        return $bondAmount;
    }

    public function getAmountInCart($productID)
    {
       return Cart::content()->where('id', $productID)->first()->qty;
    }

    public function addToCart(Request $request)
    {
        $member = $this->forumInstance->getCachedMember();
        $memberName = $member->getName();
        $totalDonated = CreditPayment::where('username', $memberName)->sum('paid'); //We process a new creditpayment when buying bonds so this total will subtract and add accordingly :)
        $calculatedTotalDonatedAfterCurrentCart = $totalDonated - $this->getBondAmountInCart();
        $currentCredits = $this->getOrMakeCredits($member->getId(), $memberName);
        $product = Product::where('id', $request->input('productID'))->where('visible', 1)->firstOrFail();
        $uniqueCartItems = Cart::content()->unique('id')->values();
        $uniqueCartItemCount = $uniqueCartItems->count();
        if ($uniqueCartItemCount >= 10 && !$uniqueCartItems->contains('id', $product->id)) {
            return response('Your cart is currently full!', 400);
        }
        if ((Cart::subtotalFloat() + $product->getDiscountedPrice()) > (int)$currentCredits) {
            return response('Based on your current cart, you cannot afford this item!', 400);
        }
        if($product->bond_amount && $calculatedTotalDonatedAfterCurrentCart < $product->bond_amount) {
            return response('You have not donated enough to purchase this many bonds! Total donated: $' . $totalDonated ?? 0);
        }
        Cart::add($request->input('productID'), $product->item_name, 1, $product->getDiscountedPrice());
        $data = [
            'shouldFail' => (float)Cart::subtotal() + (float)$product->getDiscountedPrice(),
            'currentCredits' => $currentCredits,
            'id' => $product->id,
            'item_id' => $product->item_id,
            'item_name' => $product->item_name,
            'price' => $product->getDiscountedPrice() * $this->getAmountInCart($product->id),
            'discount' => $product->item_discount,
            'quantity' => $this->getAmountInCart($product->id),
            'thumbnail_img' => $product->getThumbnailImage(),
            'total' => Cart::subtotal(),
        ];
        //Only allowed 10 different products in cart(check if we're just adding to an existing cart product)
        //Check if we're an ironman trying to add a non ironman product(we will be sending the product id so all good)
        //Check if the product id exists and also is visible
        //If it's a bond, check that we have the total donated amount to cover the subtraction
        return json_encode($data);
    }

    public function getCartTotal() {
        return response()->json(Cart::subtotal());
    }

    public function getCurrentCredits() {
        return response()->json(UserCredit::getCreditAmount($this->forumInstance->getCachedMember()->getId(), $this->forumInstance->getCachedMember()->getName()));
    }

    public function checkout() {
        if (Cart::subtotal() > UserCredit::getCreditAmount($this->forumInstance->getCachedMember()->getId(), $this->forumInstance->getCachedMember()->getName()) || Cart::count() < 1) {
            abort(404);
        }
        //Assign certain cart values to variables as we empty the cart later and want to use it on the receipt screen
        $cartArray = Cart::content();
        $subTotal = Cart::subtotal();
        \DB::transaction(function () { //Use a transaction as we don't want things going wrong and people losing out on their credits
            $usersCredits = UserCredit::where('user_id', $this->forumInstance->getCachedMember()->getId())->firstOrFail();
            $usersCredits->credits -= Cart::subtotal();
            $usersCredits->save();
            foreach (Cart::content() as $item) {
                $product = Product::findOrFail($item->id);
                $purchase = new Purchase();
                $purchase->userid = $this->forumInstance->getCachedMember()->getId();
                $purchase->username = $this->forumInstance->getCachedMember()->getName();
                $purchase->trans_id = 'SP' . Str::random();
                $purchase->item_id = $product->item_id;
                $purchase->item_amount = $product->item_amount;
                $purchase->item_name = $product->item_name;
                $purchase->quantity = $item->qty;
                $purchase->price = $item->price * $item->qty;
                $purchase->discount = $product->item_discount;
                $purchase->claimed = 0;
                $purchase->bought_on = Carbon::now();
                $purchase->save();
                if ($product->bond_amount) {
                    $transaction = new CreditPayment();
                    $transaction->username = $this->forumInstance->getCachedMember()->getName();
                    $transaction->email = $this->forumInstance->getCachedMember()->getEmail();
                    $transaction->item_name = $item->qty . 'x' . $product->item_name;
                    $transaction->paid = -1 *($product->bond_amount * $item->qty);
                    $transaction->credit_amount = 0;
                    $transaction->status = 'Completed';
                    $transaction->client_ip = request()->ip();
                    $transaction->cvc_pass = 'bond';
                    $transaction->zip_pass = 'bond';
                    $transaction->address_pass = 'bond';
                    $transaction->live_mode = 1;
                    $transaction->paid_on = Carbon::now();
                    $transaction->save();
                }
            }
            Cart::destroy();
        });
        return view('store.checkout', [
            'cart' => $cartArray,
            'subtotal' => $subTotal,
        ]);
    }

}