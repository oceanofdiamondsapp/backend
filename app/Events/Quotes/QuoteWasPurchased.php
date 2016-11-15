<?php

namespace App\Events\Quotes;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use OOD\Quotes\Quote;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentResponseType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsResponseType;

class QuoteWasPurchased extends Event
{
    use SerializesModels;

    /**
     * @var OOD\Quotes\Quote
     */
    public $quote;

    /**
     * @var PayPal\PayPalAPI\DoExpressCheckoutPaymentResponseType
     */
    public $payment;

    /**
     * @var GetExpressCheckoutDetailsResponseType
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        DoExpressCheckoutPaymentResponseType $payment,
        GetExpressCheckoutDetailsResponseType $order,
        Quote $quote
    ) {
        $this->payment = $payment;
        $this->order = $order;
        $this->quote = $quote;
    }
}
