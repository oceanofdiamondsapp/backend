<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OOD\JewelryType;
use OOD\Users\Account;
use OOD\Jobs\Metal;
use OOD\Jobs\Stone;
use OOD\Jobs\Job;
use Illuminate\Support\Facades\DB;
use OOD\Status;
use OOD\Tax;
use Response;

class JobController extends Controller
{
    /**
     * Add the authentication middleware to all routes
     * except the api routes.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['apiStore', 'apiShow']]);
    }

    /**
     * Display a listing of jobs.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->status_id) {
            $jobs = Job::where('status_id', $request->status_id)->orderBy('updated_at', 'DESC')->get();
        } else {
            $jobs = Job::orderBy('updated_at', 'DESC')->get();
        }

        $queryCount = [];

        for ($i = 1; $i < 6; $i++){
            $queryCount[$i] = Job::where('status_id', $i)->count();
        }

        return view('jobs.index', compact('jobs', 'queryCount'));
    }

    /**
     * Show a specific job.
     * 
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $job = Job::with('quotes.orders', 'quotes.declineType', 'images')->findOrFail($id);

        if ($job->has_unread_messages == 2) {
            $job->has_unread_messages = 1;
            $job->save();
        }

        $jewelryTypes = JewelryType::lists('description', 'id');
        $metalTypes = Metal::lists('description', 'id');
        $stoneTypes = Stone::lists('description', 'id');
        $taxTypes = Tax::lists('description', 'id');
        $orderStatuses = Status::whereIn('id', [7, 8, 9, 10])->orderBy('id', 'asc')->lists('description', 'id');

        return view('jobs.show', compact('job', 'jewelryTypes', 'metalTypes', 'stoneTypes', 'taxTypes', 'orderStatuses'));
    }
}
