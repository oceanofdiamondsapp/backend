<?php

namespace App\Http\Controllers;

use App\Events\Jobs\LoggableEventOccurred;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OOD\Dummy\DummyRepository;
use OOD\Status;
use Auth;

class DummyController extends Controller
{
    /**
     * A dummy repository instance.
     * 
     * @var \OOD\Dummy\DummyRepository
     */
    protected $dummy;

    /**
     * Create a new dummy controller instance.
     * 
     * @param \OOD\Dummy\DummyRepository $dummy
     */
    public function __construct(DummyRepository $dummy)
    {
        $this->middleware('auth');

        $this->dummy = $dummy;
    }

    /**
     * Create a dummy account.
     * 
     * @return void
     */
    public function account()
    {
        $account = $this->dummy->account();

        $account->save();

        $account->roles()->attach(2);

        echo 'Account created for ' . $account->name;
    }

    /**
     * Create a dummy job.
     * 
     * @return void
     */
    public function job()
    {
        $job = $this->dummy->job();

        $account = $this->dummy->randomAccount();

        $account->jobs()->save($job);

        $job->metals()->attach([rand(1, 5), rand(1, 5)]);

        $job->stones()->attach([rand(1, 4)]);

        echo 'Job ' . $job->job_number . ' created for ' . $account->name . '\'s account';
    }

    /**
     * Create a dummy quote for a random job in the database.
     * 
     * @return void
     */
    public function quote()
    {
        $job = $this->dummy->randomJob();

        $quote = $this->dummy->quote($job);

        Auth::user()->quotes()->save($quote);

        event(new LoggableEventOccurred('Quote sent by', Auth::user(), $job));

        $job->status()->associate(Status::find(3));
        
        $job->save();

        echo 'Quote ' . $quote->quote_number . ' created for job ' . $quote->job->job_number;
    }

    /**
     * Create a message (from an end user) for a random job in the database.
     * 
     * @return void
     */
    public function message()
    {
        $job = $this->dummy->randomJob();

        $message = $this->dummy->message($job);

        $message->user()->associate($job->account);

        $job->messages()->save($message);

        $job->has_unread_messages = 2;

        $job->save();

        echo 'Message saved to job ' . $job->job_number;
    }
}
