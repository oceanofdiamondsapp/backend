<?php

namespace App\Handlers\Events\Jobs;

use App\Events\Jobs\MessageWasSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class UpdateProperties
{
    /**
     * Update a job's properties when a message is sent for that specific job.
     * This can include setting the updated_at timestamp, clearing or
     * setting the message flag, or other properties as needed.
     *
     * @param  MessageWasSent  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        $event->job->updated_at = date('Y-m-d H:i:s');
        $event->job->has_unread_messages = 1;
        $event->job->save();
    }
}
