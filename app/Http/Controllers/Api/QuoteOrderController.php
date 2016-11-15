<?php

namespace App\Http\Controllers\Api;

use OOD\Quotes\Quote;

class QuoteOrderController extends ApiController
{
    public function index($id)
    {
        $quote = Quote::find($id);

        return $this->respond([
            'data' => $quote->orders
        ]);
    }
}
