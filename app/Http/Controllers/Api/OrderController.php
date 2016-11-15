<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use OOD\Users\Account;

class OrderController extends ApiController
{
    public function index()
    {
        $account = Account::where('id', Auth::user()->id)->first();

        return $this->respond([
            'data' => $account->orders
        ]);
    }
}
