<?php

namespace App\Http\Controllers;

use App\Events\Jobs\LoggableEventOccurred;
use App\Events\Quotes\QuoteWasPurchased;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OOD\Services\PayPal;
use OOD\Quotes\Quote;

class PayPalController extends Controller
{
    /**
     * @var OOD\Services\PayPal
     */
    protected $paypal;

    /**
     * Create a new paypal controller instance.
     * 
     * @param PayPal $paypal
     */
    public function __construct(PayPal $paypal)
    {
        $this->paypal = $paypal;
    }

    /**
     * Perform the express checkout if the user successfully submits payment.
     * 
     * @param  Request $request
     * @return Response
     */
    public function success(Request $request)
    {
        $token = $request->token;
        $quoteId = $request->QuoteID;
        $payerId = $request->PayerID;

        $payment = $this->paypal->doExpressCheckout($token, $payerId);
        
        $order = $this->paypal->getCheckoutDetails($token);

        $quote = Quote::with('job')->findOrFail($quoteId);
        $quote->status_id = 7; // ordered
        $quote->job->status_id = 7; // ordered
        $quote->job->save();
        $quote->save();

        event(new QuoteWasPurchased($payment, $order, $quote));
        event(new LoggableEventOccurred("Order placed for $quote->quote_number by", $quote->job->account, $quote->job));

        return redirect('paypal/thank-you');
    }

    /**
     * Page to display when user cancels their paypal checkout.
     * 
     * @return Response
     */
    public function cancel()
    {
        return 'Checkout was cancelled';
    }

    /**
     * Page to display when user completes Express Checkout.
     * 
     * @return Response
     */
    public function thanks()
    {
        return view('paypal.thanks');
    }
}
