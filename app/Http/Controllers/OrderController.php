<?php

namespace App\Http\Controllers;

use App\Events\Jobs\LoggableEventOccurred;
use App\Http\Requests;
use OOD\Services\PushNotificationService;
use Illuminate\Http\Request;
use OOD\Order;
use OOD\Status;
use Session;
use Auth;
use Mail;

class OrderController extends Controller
{
    /**
     * Add the authentication middleware to all routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the orders.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->status_id) {
            $orders = Order::where('status_id', $request->status_id)->get();
        } else {
            $orders = Order::all();
        }

        $queryCount = [];

        for ($i = 7; $i < 10; $i++){
            $queryCount[$i] = Order::where('status_id', $i)->count();
        }

        return view('orders.index', compact('orders', 'queryCount'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'tracking_url' => 'url|required_without_all:status_id',
            'status_id' => 'integer|required_without_all:tracking_url'
        ]);

        if ($validator->fails()) {
            return redirect("/jobs/".$order->quote->job_id."#orders/".$order->order_number)->withErrors($validator->errors());
        }

        $order->fill($request->all());

        $order->save();

        if ($request->tracking_url) {
            $eventMessage = "Tracking detail added to $order->order_number by";
        }
        
        if ($request->status_id) {
            $status = Status::findOrFail($request->status_id);

            $eventMessage = "Order $order->order_number set to $status->description by";

            // Send push notification(s)
            $job = $order->quote->job;
            $payload = "Order $order->order_number($job->nickname) was changed to $status->description.";
            foreach ($job->account->devices as $device) {
                PushNotificationService::send($device, $payload);
            }

            // Send Mail
            Mail::send('emails.jobs.order-has-changed', ['msg' => $payload, 'job' => $job], function ($message) use ($job) {
                $message->to($job->account->email, $job->account->name)
                    ->subject('Ocean of Diamonds Has Changed Your Order Status');
            });
        }


        event(new LoggableEventOccurred($eventMessage, Auth::user(), $order->quote->job));

        Session::flash('success', 'Order updated');

        return redirect("/jobs/".$order->quote->job_id."#orders/".$order->order_number);
    }
}
