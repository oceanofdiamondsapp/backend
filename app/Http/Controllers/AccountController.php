<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use OOD\Users\Account;

class AccountController extends Controller
{
    /**
     * Create a new account controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the 'user' accounts.
     *
     * @return Response
     */
    public function index()
    {
        $accounts = Account::orderBy('name')->get();

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);

        return view('accounts.show', compact('account'));
    }
}
