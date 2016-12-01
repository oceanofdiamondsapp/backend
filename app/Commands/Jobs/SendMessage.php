<?php

namespace App\Commands\Jobs;

use App\Commands\Command;
use App\Events\Jobs\LoggableEventOccurred;
use App\Events\Jobs\MessageWasSent;
use App\Http\Requests\MessageRequest;
use Auth;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;
use OOD\Image;
use OOD\Jobs\Job;
use OOD\Message;
use OOD\Services\PushNotificationService;

class SendMessage extends Command implements SelfHandling
{
    /**
     * @var App\Http\Requests\MessageRequest
     */
    protected $request;

    /**
     * @var int
     */
    protected $job_id;

    /**
     * @var OOD\Helpers\Uploader
     */
    protected $uploader;

    /**
     * Create a new command instance.
     *
     * @param Request $request
     * @param int     $job_id
     */
    public function __construct(Request $request, $job_id)
    {
        $this->request = $request;
        $this->job_id = $job_id;
        $this->uploader = \App::make('OOD\Services\Uploader');
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        // Fetch job
        $job = Job::findOrFail($this->job_id);

        // Save message
        $message = new Message($this->request->all());
        $message->user()->associate(Auth::user());
        $job->messages()->save($message);

        // Upload files
        if ($this->request->hasFile('images')) {
            foreach ($this->request->file('images') as $img) {
                $fileName = $this->uploader->uploadFileForJob($img, $job->job_number);
                $image = new Image(['path' => $fileName]);
                $image->user()->associate(Auth::user());
                $message->images()->save($image);
            }
        }

        // Send push notification(s)
        foreach ($job->account->devices as $device) {
            $payload = 'You have a new message in job #' . $job->job_number . ' - ' . $job->nickname;
            PushNotificationService::send($device, $payload);
        }

        // Send email
        event(new MessageWasSent($message, $job));

//        $job->has_unread_messages = 0;
//        $job->save();

        // Add record to event log
        event(new LoggableEventOccurred('Message sent by', Auth::user(), $job));
    }
}
