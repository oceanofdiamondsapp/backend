<?php

namespace OOD\Services;

use OOD\Quotes\Quote;
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsItemType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentReq;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsReq;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;

class PayPal
{
    /**
     * @var PayPal\Service\PayPalAPIInterfaceServiceService
     */
    protected $apiInterfaceService;
    
    /**
     * Create a new paypal instance. 
     */
    public function __construct()
    {
        $this->apiInterfaceService = new PayPalAPIInterfaceServiceService([
            'mode' => env('PAYPAL_MODE'),
            'log.LogEnabled' => env('PAYPAL_LOG_ENABLED'),
            'log.FileName' => env('PAYPAL_LOG_FILE_NAME'),
            'log.LogLevel' => env('PAYPAL_LOG_LEVEL'),
            'acct1.UserName' => env('PAYPAL_USERNAME'),
            'acct1.Password' => env('PAYPAL_PASSWORD'),
            'acct1.Signature' => env('PAYPAL_SIGNATURE')
        ]);
    }

    /**
     * Set up the express checkout order details and attempt to
     * make the express checkout api call.
     * 
     * @param  Quote  $quote
     * @return SetExpressCheckoutReq
     */
    public function setExpressCheckout(Quote $quote)
    {
        $item = $this->createItem($quote);
        $payment = $this->createPayment($quote, $item);
        $details = $this->createRequestDetails($quote, $payment);
        $type = $this->setRequestType($details);
        $request = $this->createRequest($type);

        try {
            $setECResponseType = $this->apiInterfaceService->SetExpressCheckout($request);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $setECResponseType;
    }

    /**
     * Do the express checkout.
     * 
     * @param  string                               $token
     * @param  string                               $payerId
     * @return DoExpressCheckoutPaymentResponseType
     */
    public function doExpressCheckout($token, $payerId)
    {
        $checkoutDetails = $this->getCheckoutDetails($token);

        $paymentDetails = $checkoutDetails->GetExpressCheckoutDetailsResponseDetails->PaymentDetails[0];

        $doECRequestDetails = new DoExpressCheckoutPaymentRequestDetailsType();
        $doECRequestDetails->PayerID = $payerId;
        $doECRequestDetails->Token = $token;
        $doECRequestDetails->PaymentDetails[0] = $paymentDetails;

        $doECRequest = new DoExpressCheckoutPaymentRequestType();
        $doECRequest->DoExpressCheckoutPaymentRequestDetails = $doECRequestDetails;

        $doECReq = new DoExpressCheckoutPaymentReq();
        $doECReq->DoExpressCheckoutPaymentRequest = $doECRequest;

        try {
            $doECResponse = $this->apiInterfaceService->DoExpressCheckoutPayment($doECReq);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $doECResponse;
    }

    /**
     * Get express checkout details.
     * 
     * @param  string                                $token
     * @return GetExpressCheckoutDetailsResponseType
     */
    public function getCheckoutDetails($token)
    {
        $getExpressCheckoutDetailsRequest = new GetExpressCheckoutDetailsRequestType($token);

        $getExpressCheckoutReq = new GetExpressCheckoutDetailsReq();
        $getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;

        try {
            $response = $this->apiInterfaceService->GetExpressCheckoutDetails($getExpressCheckoutReq);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $response;
    }

    /**
     * Create an order item.
     * 
     * @param  Quote                  $quote
     * @return PaymentDetailsItemType
     */
    private function createItem(Quote $quote)
    {
        $item = new PaymentDetailsItemType();
        $item->Name = $quote->quote_number;
        $item->Description = $quote->job->nickname;
        $item->Amount = $quote->price;
        $item->Quantity = 1;
        $item->ItemCategory = 'Physical';
        $item->Tax = new BasicAmountType('USD', $quote->tax_due);
        return $item;
    }

    /**
     * Create a payment details type.
     * 
     * @param  Quote                  $quote
     * @param  PaymentDetailsItemType $item 
     * @return PaymentDetailsType
     */
    private function createPayment(Quote $quote, PaymentDetailsItemType $item)
    {
        $payment = new PaymentDetailsType();
        $payment->PaymentDetailsItem[] = $item;
        $payment->ItemTotal = new BasicAmountType('USD', $quote->price);
        $payment->TaxTotal = new BasicAmountType('USD', $quote->tax_due);
        $payment->OrderTotal = new BasicAmountType('USD', $quote->total_due);
        $payment->PaymentAction = 'Sale';
        $payment->HandlingTotal = 0;
        $payment->InsuranceTotal = 0;
        $payment->ShippingTotal = new BasicAmountType('USD', $quote->shipping);
        $payment->OrderDescription = $quote->job->nickname;
        return $payment;
    }

    /**
     * Create an express checkout request details type.
     *
     * @param  Quote                                $quote
     * @param  PaymentDetailsType                   $payment
     * @return SetExpressCheckoutRequestDetailsType
     */
    private function createRequestDetails(Quote $quote, PaymentDetailsType $payment)
    {
        $details = new SetExpressCheckoutRequestDetailsType();
        $details->PaymentDetails[0] = $payment;
        $details->CancelURL = env('PAYPAL_CANCEL_URL');
        $details->ReturnURL = env('PAYPAL_SUCCESS_URL') . "?QuoteID=" . $quote->id;
        $details->NoShipping = 0;
        return $details;
    }

    /**
     * Set the request type details.
     * 
     * @param  SetExpressCheckoutRequestDetailsType $details
     * @return SetExpressCheckoutRequestType
     */
    private function setRequestType(SetExpressCheckoutRequestDetailsType $details)
    {
        $requestType = new SetExpressCheckoutRequestType();
        $requestType->SetExpressCheckoutRequestDetails = $details;
        return $requestType;
    }

    /**
     * Create the express checkout request.
     * 
     * @param  SetExpressCheckoutRequestType $type
     * @return SetExpressCheckoutReq
     */
    private function createRequest(SetExpressCheckoutRequestType $type)
    {
        $request = new SetExpressCheckoutReq();
        $request->SetExpressCheckoutRequest = $type;
        return $request;
    }
}
