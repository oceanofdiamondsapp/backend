<?php

namespace App\Http\Controllers;

use App\Events\Jobs\LoggableEventOccurred;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OOD\Order;
use OOD\Note;
use OOD\Jobs\Job;
use Auth;
use Session;

class OrderNoteController extends Controller
{
    /**
     * Create a new quote note controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Add a new note to the specified order.
     *
     * @return Response
     */
    public function store(Request $request, $pp_transaction_id)
    {
        $order = Order::findOrFail($pp_transaction_id);

        $redirectTo  = "/jobs/".$order->quote->job_id."#orders/".$order->order_number;

        $validator = \Validator::make($request->all(), [
            'body' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($redirectTo)->withErrors($validator->errors());
        }

        $note = new Note($request->all());
        $note->user()->associate(Auth::user());
        $order->notes()->save($note);

        $job = Job::findOrFail($order->quote->job_id);
        event(new LoggableEventOccurred("Note added to order $order->order_number by", Auth::user(), $job));

        Session::flash('success', 'Note added');

        return redirect($redirectTo);
    }
}
