<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Stripe;

class StripeController extends Controller
{
    //
    public function checkout(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 2000,  // Amount in cents (2000 = $20.00)
            'currency' => 'usd',  // Currency
            'payment_method' => 'pm_card_visa',  // Example payment method ID (replace with real method ID)
            'payment_method_types' => ['card'],  // Specify the payment method types
        ]);
        
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'T-shirt'],
                        'unit_amount' => $request->price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment-cancel'),
        ]);
        if (isset($response->id) && $response->id != '') {
            session()->put('product_name', "dslkjnsdkbfdskjb");
            session()->put('quantity', '1');
            session()->put('price', '2000');
            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        if (isset($request->session_id)) {
            $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            // Check if customer_name is available, otherwise set it to an empty string or a placeholder
            $customer_name = isset($response->customer_details->name) ? $response->customer_details->name : 'Unknown Customer';

            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->product_name = session()->get('product_name');
            $payment->quantity = session()->get('quantity');
            $payment->amount = session()->get('price');
            $payment->currency = $response->currency;
            $payment->customer_name = $customer_name; // Ensure this is not null
            $payment->customer_email = $response->customer_details->email;
            $payment->payment_status = $response->status;
            $payment->payment_methods = "Stripe";
            $payment->save();

            return "Payment is Successful";
        } else {
            return redirect()->route('payment-cancel');
        }
    }


    public function cancel()
    {
        return "Payment is Canceled";
    }
}
