<?php

namespace App\Http\Controllers;

use App\Events\Jobs\LoggableEventOccurred;
use App\Events\Jobs\MessageWasSent;
use App\Events\Quotes\QuoteWasSent;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\QuoteRequest;
use Auth;
use Illuminate\Http\Request;
use OOD\Event;
use OOD\JewelryType;
use OOD\Jobs\Job;
use OOD\Jobs\Metal;
use OOD\Message;
use OOD\Note;
use OOD\Quotes\Quote;
use OOD\Services\PayPal;
use OOD\Services\PushNotificationService;
use OOD\Status;
use OOD\Tax;
use Session;

class QuoteController extends Controller
{
    /**
     * Create a new quote controlle instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $quotes = Quote::with('request.account', 'status')->get();

        return view('quotes.index', compact('quotes'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  int  $id
     * @return Response
     */
    public function store(QuoteRequest $request, $job_id)
    {
        /////////////////////////////////////////////////
        //                  CHECKLIST                  //
        /////////////////////////////////////////////////
        // X Generate formatted quote ID w/ versioning //
        // X Update job model status                   //
        // X Update updated_at timestamp on job model  //
        // X Send email to user                        //
        // X Create internal note                      //
        //   Send push notification to user            //
        /////////////////////////////////////////////////

        // Set up formatted quote number based on job id
        $alpha = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $job = Job::with('quotes')->findOrFail($job_id);
        $quote_number = 'Q' . $job->job_number . ucfirst($alpha[$job->quotes->count()]);

        // Create quote model
        $quote = new Quote($request->all() + [
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 month')),
            'quote_number' => $quote_number
        ]);

        // Set relationships (foreign keys)
        $quote->job()->associate(Job::findOrFail($job_id));
        $quote->status()->associate(Status::findOrFail(6));
        $quote->tax()->associate(Tax::findOrFail($request->tax_id));
        $quote->jewelryType()->associate(JewelryType::findOrFail($request->jewelry_type_id));

        // Save the quote
        Auth::user()->quotes()->save($quote);

        // Trigger quote was sent event
        event(new QuoteWasSent($quote));

        // Log event
        event(new LoggableEventOccurred('Quote sent by', Auth::user(), $job));

        // Update the parent job's status
        $job = Job::findOrFail($job_id);
        $job->status()->associate(Status::findOrFail(3));
        $job->save();

        // Optionally send a message to the user
        if (! empty($request->get('message'))) {
            $message = new Message(['body' => $request->message]);
            $message->user()->associate(Auth::user());
            $quote->messages()->save($message);

            event(new MessageWasSent($message, $job));
        }

        // Optionally add a note to the quote
        if (! empty($request->get('quote_note'))) {
            $note = new Note(['body' => $request->quote_note]);
            $note->user()->associate(Auth::user());
            $quote->notes()->save($note);
        }

        // Send push notification
        foreach ($job->account->devices as $device) {
            $payload = 'You have a new quote';
            PushNotificationService::send($device, $payload);
        }

        // Success message
        Session::flash('success', 'Quote created and sent');

        // Redirect user to the job detail view
        return redirect("/jobs/$job_id#quotes");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $quote = Quote::with('jewelryType', 'declineType', 'tax',
                             'notes.user', 'messages.user', 'user',
                             'request.account', 'metals')->findOrFail($id);

        return $quote;
    }

    /**
     * Start the express checkout process.
     * 
     * @param  string   $quote_number
     * @param  PayPal   $paypal
     * @return Response
     */
    public function checkout(PayPal $paypal, $quote_number)
    {
        $quote = Quote::with('job', 'tax')
            ->where('quote_number', $quote_number)
            ->first();

        $expressCheckoutResponse = $paypal->setExpressCheckout($quote);

        return redirect(
            env('PAYPAL_ORDER_URL') .
            $expressCheckoutResponse->Token .
            "&QuoteNumber=" . $quote_number
        );
    }
}
