<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use OOD\Jobs\Job;
use OOD\Order;
use OOD\Quotes\Quote;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $activity = [];

        $activity['requestsThisMonth'] = Job::where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->count();
        $activity['ordersThisMonth']   = Order::where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->count();
        $activity['declinedToDate']    = Quote::where('status_id', 5)->count();
        $activity['requestsToDate']    = Job::count();
        $activity['ordersToDate']      = Order::count();
        $activity['lapsedToDate']      = Quote::where('expires_at', '<', date('Y-m-d H:i:s'))->count();
        $activity['averageValue']      = number_format(DB::table('orders')->avg('pp_gross_amount'), 2, '.', ',');
        $activity['newRequests']       = Job::where('status_id', 1)->count();
        $activity['newMessages']       = Job::where('has_unread_messages', 2)->count();
        $activity['inProgress']        = Order::where('status_id', 10)->count();
        $activity['totalValue']        = number_format(DB::table('orders')->sum('pp_gross_amount'), 2, '.', ',');
        $activity['newOrders']         = Order::where('status_id', 7)->count();
        $activity['completed']         = Order::where('status_id', 9)->count();
        $activity['shipping']          = Order::where('status_id', 8)->count();
        $activity['idle']              = Job::where('updated_at', '<', date('Y-m-d H:i:s', strtotime('-7 days')))->count();

        return view('pages.dashboard', compact('activity'));
    }
}
