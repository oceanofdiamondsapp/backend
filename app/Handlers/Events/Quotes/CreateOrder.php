<?php

namespace App\Handlers\Events\Quotes;

use App\Events\Quotes\QuoteWasPurchased;
use App\Exceptions\PayPalOrderFailedException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use OOD\Order;

class CreateOrder
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QuoteWasPurchased  $event
     * @return void
     */
    public function handle(QuoteWasPurchased $event)
    {
        if ($event->payment->Ack === 'Failure') {
            throw new PayPalOrderFailedException('There was an error processing your payment. Please try again. If the problem persists, pleace contact Ocean of Diamonds.');
        }

        $payment = $event->payment->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0];

        $payer = $event->order->GetExpressCheckoutDetailsResponseDetails->PayerInfo;

        $order = new Order([
            'pp_ship_to_addr_status' => $payer->Address->AddressStatus,
            'pp_ship_to_addr_state'  => $payer->Address->StateOrProvince,
            'pp_ship_to_addr_line1'  => $payer->Address->Street1,
            'pp_ship_to_addr_line2'  => $payer->Address->Street2,
            'pp_ship_to_addr_name'   => $payer->Address->Name,
            'pp_ship_to_addr_city'   => $payer->Address->CityName,
            'pp_ship_to_addr_zip'    => $payer->Address->PostalCode,
            'pp_transaction_id'      => $payment->TransactionID,
            'pp_gross_amount'        => $payment->GrossAmount->value,
            'pp_payer_status'        => $payer->PayerStatus,
            'pp_payer_email'         => $payer->Payer,
            'pp_payer_name'          => $payer->PayerName->FirstName . ' ' . $payer->PayerName->LastName,
            'pp_fee_amount'          => $payment->FeeAmount->value,
            'pp_tax_amount'          => $payment->TaxAmount->value,
            'order_number'           => 'O' . substr($event->quote->quote_number, 1),
            'pp_payer_id'            => $payer->PayerID,
            'pp_token'               => $event->payment->DoExpressCheckoutPaymentResponseDetails->Token,
        ]);

        $order->quote()->associate($event->quote);

        $order->save();
    }
}
