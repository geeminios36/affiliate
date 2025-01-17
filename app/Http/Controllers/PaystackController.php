<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerPackageController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use App\Seller;
use App\CustomerPackage;
use App\SellerPackage;
use Auth;
use Session;
use Redirect;
use Paystack;

class PaystackController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        if (Session::get('payment_type') == 'cart_payment') {
            $order = Order::where('id', Session::get('order_id'))->first();
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round($order->grand_total * 100);
            $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');
            $request->reference = Paystack::genTranxRef();
            return Paystack::getAuthorizationUrl()->redirectNow();
        } elseif (Session::get('payment_type') == 'wallet_payment') {
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round(Session::get('payment_data')['amount'] * 100);
            $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');
            $request->reference = Paystack::genTranxRef();
            return Paystack::getAuthorizationUrl()->redirectNow();
        } elseif (Session::get('payment_type') == 'customer_package_payment') {
            $customer_package = CustomerPackage::where('id', Session::get('payment_data')['customer_package_id'])->first();
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round($customer_package->amount * 100);
            $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');
            $request->reference = Paystack::genTranxRef();
            return Paystack::getAuthorizationUrl()->redirectNow();
        } elseif (Session::get('payment_type') == 'seller_package_payment') {
            $seller_package = SellerPackage::where('id', Session::get('payment_data')['seller_package_id'])->first();
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round($seller_package->amount * 100);
            $request->currency = env('PAYSTACK_CURRENCY_CODE', 'NGN');
            $request->reference = Paystack::genTranxRef();
            return Paystack::getAuthorizationUrl()->redirectNow();
        }
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        if (Session::has('payment_type')) {
            if (Session::get('payment_type') == 'cart_payment') {
                $payment = Paystack::getPaymentData();
                $payment_detalis = json_encode($payment);
                if (!empty($payment['data']) && $payment['data']['status'] == 'success') {
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('order_id'), $payment_detalis);
                }
                Session::forget('order_id');
                flash(translate('Payment cancelled'))->success();
                return redirect()->route('home');
            } elseif (Session::get('payment_type') == 'wallet_payment') {
                $payment = Paystack::getPaymentData();
                $payment_detalis = json_encode($payment);
                if (!empty($payment['data']) && $payment['data']['status'] == 'success') {
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                Session::forget('payment_data');
                flash(translate('Payment cancelled'))->success();
                return redirect()->route('home');
            } elseif (Session::get('payment_type') == 'customer_package_payment') {
                $payment = Paystack::getPaymentData();
                $payment_detalis = json_encode($payment);
                if (!empty($payment['data']) && $payment['data']['status'] == 'success') {
                    $customer_package_controller = new CustomerPackageController;
                    return $customer_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
                Session::forget('payment_data');
                flash(translate('Payment cancelled'))->success();
                return redirect()->route('home');
            } elseif (Session::get('payment_type') == 'seller_package_payment') {
                $payment = Paystack::getPaymentData();
                $payment_detalis = json_encode($payment);
                if (!empty($payment['data']) && $payment['data']['status'] == 'success') {
                    $seller_package_controller = new SellerPackageController;
                    return $seller_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
                Session::forget('payment_data');
                flash(translate('Payment cancelled'))->success();
                return redirect()->route('home');
            }
        }

        // for mobile app
        if (!Session::has('payment_type')) {
            $payment = Paystack::getPaymentData();
            $payment_details = json_encode($payment);
            if (!empty($payment['data']) && $payment['data']['status'] == 'success') {
                return response()->json(['result' => true, 'message' => "Payment is successful", 'payment_details' => $payment_details]);
            } else {
                return response()->json(['result' => false, 'message' => "Payment unsuccessful", 'payment_details' => $payment_details]);
            }

        }
    }
}
