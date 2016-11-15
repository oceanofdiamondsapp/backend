<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use OOD\Image;
use OOD\Jobs\Job;
use OOD\Services\Uploader;
use OOD\Users\Account;

class JobController extends ApiController
{
    /**
     * Get all jobs for the authenticated user.
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::with('quotes', 'quotes.status', 'stones', 'metals', 'status', 'messages', 'images')
            ->where('account_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $this->respond([
            'data' => $jobs
        ]);
    }

    /**
     * Create a new job for the authenticated user.
     * 
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Uploader $uploader, Request $request)
    {
        // Validate request.
        $rules = array(
            'ship_to_state' => 'required',
            'deadline'      => 'required|date',
            'nickname'      => 'required',
            'budget'        => 'required|numeric',
            'carat'         => 'required|numeric',
            'notes'         => 'required',
        );

        $validator = Validator::make($request->job, $rules);

        if ($validator->fails()) {
            return $this->respondBadRequest(['error' => $validator->messages()->first()]);
        }

        // Create new job.
        $job = new Job($request->job);

        $job->deadline = date('Y-m-d', strtotime($request->job['deadline']));

        $account = Account::find(Auth::user()->id);
        $account->jobs()->save($job);

        $job->metals()->attach($request->job['metal_type_ids']);
        $job->stones()->attach($request->job['stones']);

        // Upload photos for job.
        if ($request->photos) {
            foreach ($request->photos as $photo) {
                $directory = 'uploads/' . $job->job_number;
                $filename = microtime(true) . '-user_upload.jpg';
                $path = $directory . '/' . $filename;

                if (! file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $fp = fopen($path, 'w');
                fwrite($fp, base64_decode($photo));
                fclose($fp);

                $image = new Image(['path' => $path]);
                $image->user()->associate(Auth::user());
                $job->images()->save($image);
            }
        }

        return $this->respond(['data' => $job]);
    }
}
