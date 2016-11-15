<?php

namespace App\Http\Controllers\Api;

use App\Events\Jobs\LoggableEventOccurred;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OOD\Quotes\Quote;
use OOD\Services\PayPal;

class QuoteController extends ApiController
{
    /**
     * Return a json string of the quote details.
     * 
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $quote = Quote::findOrFail($id);

        return $this->respond([
            'data' => $quote
        ]);
    }

    /**
     * Decline the specified quote.
     * 
     * @param  itneger $id
     * @return Illuminate\Http\Response
     */
    public function decline(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $authorized = (Auth::user()->id == $quote->job->account_id);

        if (! $authorized) {
            return $this->respondBadRequest('Unauthorized');
        }

        $quote->status_id = 5;
        $quote->decline_type_id = $request->decline_type_id;
        $quote->job->status_id = 5;
        $quote->job->save();
        $quote->save();

        event(new LoggableEventOccurred('Quote declined by ', Auth::user(), $quote->job));

        return $this->respond([
            'status' => 'success'
        ]);
    }

    /**
     * Start the express checkout process.
     * 
     * @param  string   $quote_number
     * @param  PayPal   $paypal
     * @return Response
     */
    public function checkout(PayPal $paypal, $quote_number)
    {
        $quote = Quote::with('job', 'tax')
            ->where('quote_number', $quote_number)
            ->first();

        $expressCheckoutResponse = $paypal->setExpressCheckout($quote);

        return redirect(
            env('PAYPAL_ORDER_URL') .
            $expressCheckoutResponse->Token .
            "&QuoteNumber=" . $quote_number
        );
    }
}
