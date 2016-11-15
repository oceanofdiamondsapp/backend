<?php

namespace App\Events\Jobs;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class MessageWasSent extends Event
{
    use SerializesModels;

    /**
     * @var OOD\Message
     */
    public $message;

    /**
     * @var OOD\Jobs\Job
     */
    public $job;

    /**
     * Create a new message was sent event instance.
     *
     * @return void
     */
    public function __construct($message, $job)
    {
        $this->message = $message;
        $this->job = $job;
    }
}
