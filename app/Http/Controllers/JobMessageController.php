<?php

namespace App\Http\Controllers;

use App\Commands\Jobs\SendMessage;
use App\Events\Jobs\MessageWasSent;
use App\Events\Jobs\LoggableEventOccurred;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class JobMessageController extends Controller
{
    /**
     * @var OOD\Helpers\Uploader
     */
    protected $uploader;

    /**
     * Create a new job message controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->uploader = \App::make('OOD\Services\Uploader');
    }

    /**
     * Save the job message to storage.
     *
     * @param  Request  $request
     * @param  int      $job_id
     * @return Redirect
     */
    public function store(Request $request, $job_id)
    {
        $validator = \Validator::make($request->all(), [
            'body' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("/jobs/$job_id#messages")->withErrors($validator->errors());
        }

        if ($request->hasFile('images')) {
            if ($this->uploader->exceedsMaxSize($request->file('images'))) {
                $errors = collect(['The uploads must be under 2 MB total.']);
                return redirect("/jobs/$job_id#messages")->with('errors', $errors)->withInput();
            }
        }

        $this->dispatch(new SendMessage($request, $job_id));

        Session::flash('success', 'Message sent');

        return redirect("/jobs/$job_id#messages");
    }
}
