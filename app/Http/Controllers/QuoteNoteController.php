<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\NoteRequest;
use App\Http\Controllers\Controller;
use App\Events\Jobs\LoggableEventOccurred;
use Illuminate\Http\Request;
use OOD\Quotes\Quote;
use OOD\Note;
use OOD\Jobs\Job;
use Auth;
use Session;

class QuoteNoteController extends Controller
{
    /**
     * Create a new quote note controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new note on a quote.
     *
     * @param  Request  $request
     * @param  int      $quote_id
     * @return Redirect
     */
    public function store(Request $request, $quote_id)
    {
        $quote = Quote::findOrFail($quote_id);

        $validator = \Validator::make($request->all(), [
            'body' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("/jobs/$quote->job_id#quotes/$quote->quote_number")->withErrors($validator->errors());
        }

        $note = new Note($request->all());
        $note->user()->associate(Auth::user());
        $quote->notes()->save($note);

        $job = Job::findOrFail($quote->job_id);
        event(new LoggableEventOccurred("Note added to quote $quote->quote_number by", Auth::user(), $job));

        Session::flash('success', 'Note added');

        return redirect("/jobs/$quote->job_id#quotes/$quote->quote_number");
    }
}
