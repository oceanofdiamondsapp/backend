@extends('app')

@section('content')
	<div class="page-header">
		<h1>Orders</h1>
	</div>

	<ul class="list-inline mb30">
		<li>Filter By:</li>
		<li><a href="/orders" class="btn {{ !Request::has('status_id') ? 'btn-primary' : 'btn-default' }}">All</a></li>
		<li><a href="/orders?status_id=7" class="btn {{ Request::get('status_id') == 7 ? 'btn-primary' : 'btn-default' }}">Ordered ({{ $queryCount[7] }})</a></li>
		<li><a href="/orders?status_id=8" class="btn {{ Request::get('status_id') == 8 ? 'btn-primary' : 'btn-default' }}">Shipped ({{ $queryCount[8] }})</a></li>
		<li><a href="/orders?status_id=9" class="btn {{ Request::get('status_id') == 9 ? 'btn-primary' : 'btn-default' }}">Completed ({{ $queryCount[9] }})</a></li>
	</ul>

	<table id="datatable" class="table table-bordered table-striped text-center">
		<thead>
			<tr>
				<th class="text-center">Action</th>
				<th class="text-center">Order Number</th>
				<th class="text-center">Customer</th>
				<th class="text-center">Nickname</th>
				<th class="text-center">Ordered</th>
				<th class="text-center">Update</th>
				<th class="text-center"><i class="fa fa-envelope"></i></th>
				<th class="text-center">Status</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($orders as $order)
				<tr>
					<td><a href="/jobs/{{ $order->quote->job->id }}#orders/{{ $order->order_number }}" class="btn btn-default btn-xs">View</a></td>
					<td>{{ $order->order_number }}</td>
					<td>{{ $order->quote->job->account->name }}</td>
					<td>{{ $order->quote->job->nickname }}</td>
					<td>{{ $order->created_at->format('n/j/y g:i A') }}</td>
					<td>{{ $order->updated_at->format('n/j/y g:i A') }}</td>
					<td>
						@if ($order->has_unread_messages == 0)
						@elseif ($order->has_unread_messages == 1)
							<i class="fa fa-envelope"></i>
						@else
							<i class="fa fa-envelope" style="color:rgb(255,80,80);"></i>
						@endif
					</td>
					<td>{{ $order->status->description }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection