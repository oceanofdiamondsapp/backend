<?php

namespace App\Handlers\Events\Jobs;

use App\Events\Jobs\LoggableEventOccurred;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;
use OOD\Jobs\Event;

class LogEvent
{
    /**
     * Save the event to the events table. This can be something like a
     * message being sent for a job, or a note being saved to a quote.
     *
     * @param  LoggableEventOccurred  $event
     * @return void
     */
    public function handle(LoggableEventOccurred $e)
    {
        $event = new Event(['description' => $e->description]);
        $event->user()->associate($e->user);
        $e->job->events()->save($event);
    }
}
