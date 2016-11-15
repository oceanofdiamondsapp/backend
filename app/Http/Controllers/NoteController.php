<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\NoteRequest;
use App\Http\Controllers\Controller;
use OOD\Note;
use OOD\Users\User;
use OOD\Users\Account;
use Auth;
use Illuminate\Http\Request;

class NoteController extends Controller
{
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

        return redirect()->back();
    }
}
