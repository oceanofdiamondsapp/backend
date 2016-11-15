<?php

namespace App\Http\Controllers\Api;

use App\Events\Jobs\LoggableEventOccurred;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Auth;
use OOD\Jobs\Job;
use OOD\Message;

class JobMessageController extends ApiController
{
    public function store(MessageRequest $request, $job_id)
    {
        $job = Job::findOrFail($job_id);

        $message = new Message($request->all());
        $message->user()->associate(Auth::user());
        $job->messages()->save($message);
        $job->has_unread_messages = 2;
        $job->save();

        event(new LoggableEventOccurred('Message sent by', Auth::user(), $job));

        $job = Job::with('quotes', 'quotes.status', 'messages', 'images')->findOrFail($job_id);

        return $this->respond([
            'data' => $job
        ]);
    }
}
