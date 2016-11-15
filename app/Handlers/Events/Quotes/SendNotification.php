<?php

namespace App\Handlers\Events\Quotes;

use App\Events\Quotes\QuoteWasSent;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Mail;

class SendNotification
{
    /**
     * Send an email notification to the user when a quote is sent by OOD.
     *
     * @param  QuoteWasSent  $event
     * @return void
     */
    public function handle(QuoteWasSent $event)
    {
        Mail::send('emails.quotes.quote-was-sent', ['quote' => $event->quote], function ($message) use ($event) {
            $message->to($event->quote->job->account->email, $event->quote->job->account->name)
                    ->subject('Ocean of Diamonds Has Sent You a New Quote');
        });
    }
}
