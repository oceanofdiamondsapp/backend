<?php

namespace App\Events\Quotes;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class QuoteWasSent extends Event
{
    use SerializesModels;

    /**
     * @var OOD\Quotes\Quote
     */
    public $quote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }
}
