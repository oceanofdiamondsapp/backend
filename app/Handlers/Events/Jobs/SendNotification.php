<?php

namespace App\Handlers\Events\Jobs;

use App\Events\Jobs\MessageWasSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Mail;

class SendNotification
{
    /**
     * Send an email notification to the user when a message is sent for a specific job.
     *
     * @param  JobMessageWasCreated  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        Mail::send('emails.jobs.message-was-sent', ['msg' => $event->message, 'job' => $event->job], function ($message) use ($event) {
            $message->to($event->job->account->email, $event->job->account->name)
                    ->subject('Ocean of Diamonds Has Sent You a Message');
        });
    }
}
