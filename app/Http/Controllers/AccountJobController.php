<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use OOD\Users\Account;
use Response;

class AccountJobController extends Controller
{
    public function apiIndex($id)
    {
        $account = Account::with('jobs.quotes.user', 'jobs.quotes.status', 'notes.user', 'quotes.user')->findOrFail($id);

        return Response::json([
            'jobs' => $account->jobs
        ], 200);
    }
}
