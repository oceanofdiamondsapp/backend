<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use OOD\Note;
use OOD\Users\User;
use OOD\Users\Account;
use Auth;
use Session;

class AccountNoteController extends Controller
{
    /**
     * Create a new account note controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Write a note on a specific account.
     *
     * @param  NoteRequest $request
     * @return Response
     */
    public function store(NoteRequest $request, $id)
    {
        $account = Account::findOrFail($id);
        $note = new Note($request->all());
        $note->user()->associate(Auth::user());
        $account->notes()->save($note);

        Session::flash('success', 'Note added');

        return redirect()->back();
    }
}
