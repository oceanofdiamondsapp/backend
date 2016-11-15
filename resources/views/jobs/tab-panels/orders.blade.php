<ul class="list-unstyled">
	@foreach ($job->orders as $order)
		<li>
			<a href="#{{ $order->order_number }}" data-toggle="subpanel">
				{{ $order->order_number }} -  Ordered {{ $order->created_at->format('n/j/y') }}
			</a>
		</li>
	@endforeach
</ul>

<div class="tab-content">
	@foreach ($job->orders as $order)
		@include('jobs.print-wildly', ['order' => $order])

		<div class="tab-pane hidden-print" id="{{ $order->order_number }}" data-subpanel-id="{{ $order->order_number }}">
			<a href="#" data-close="subpanel" data-target-pane-id="orders" class="pull-right text-danger">
				<i class="fa fa-2x fa-times-circle"></i>
			</a>

			<h4>Order: {{ $order->order_number }}</h4>

			<p>Ordered {{ $order->created_at->format('n/d/y') }}</p>

			<div class="form-group pull-left">
				{{--<a class="btn btn-primary">Print</a>--}}
				<a id="{{'print-wild'.$order->order_number}}" href="#" class="btn btn-primary" onclick="onPrintFriend(this)">Print</a>
			</div>

			<div class="pull-right">
				{!! Form::model($order, ['route' => ['orders.update', $order->pp_transaction_id], 'method' => 'PATCH']) !!}
					<div class="form-group">
						{!! Form::select('status_id', $orderStatuses, null, ['class' => 'form-control', 'data-on-change' => 'submit']) !!}
					</div>
				{!! Form::close() !!}
			</div>

			<div class="clearfix"></div>

			<p>
				<strong>Jewelry Type</strong><br>
				{{ $order->quote->jewelryType->description }}
			</p>

			<p>
				<strong>Description</strong><br>
				{{ $order->quote->description }}
			</p>

			<p>
				<strong>Gemstones</strong><br>
				{{ $order->quote->stones_description }}
			</p>

			<p>
				<strong>Metals</strong><br>
				{{ $order->quote->metals_description }}
			</p>

			<p>
				<strong>Details</strong><br>
				Setting: {{ $order->quote->setting_details }}<br>
				Size: {{ $order->quote->size_details }}
			</p>

			<p>
				<strong>Other Details</strong><br>
				{{ $order->quote->other_details }}
			</p>

			<hr>

			<p>
				<strong>Price</strong> <small>(Only total price and tax amount is shown to the client)</small><br>
				Piece: {{ $order->quote->price_formatted }}<br>
				Tax: {{ $order->quote->tax_due_formatted }} ({{ $order->quote->tax->description }})<br>
				Shipping: {{ $order->quote->shipping_formatted }}<br>
			</p>

			<ul class="list-inline">
				<li><strong>Quote</strong></li>
				<li><span class="text-xl">{{ $order->quote->total_due_formatted }}</span></li>
			</ul>

			<hr>

			<p><strong>Internal Notes</strong> <small>(Not visible to the client)</small></p>

			@foreach ($order->notes as $note)
				<div class="panel panel-default">
					<div class="panel-body">
						<strong>{{ $note->user->name }} on {{ $note->created_at->format('n/j/y g:i A') }}</strong><br>
						{!! nl2br($note->body) !!}
					</div>
				</div>
			@endforeach

			@unless (count($order->notes))
				<p>There are no notes</p>
			@endunless

			{!! Form::open(['route' => ['orders.notes.store', $order->pp_transaction_id]]) !!}
				<div class="form-group">
					{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group clearfix">
					{!! Form::submit('Add Note', ['class' => 'btn btn-primary pull-right']) !!}
				</div>
			{!! Form::close() !!}

			<hr>

			{!! Form::model($order, ['route' => ['orders.update', $order->pp_transaction_id], 'method' => 'PATCH']) !!}
				<div class="form-group {{ !$errors->has('stones_description') ?: 'has-error' }}">
					<label for="tracking_url">
						<strong>Tracking Detail</strong> (past in full link from messenger's website)
					</label>
					{!! Form::text('tracking_url', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group clearfix">
					{!! Form::submit('Add Tracking', ['class' => 'btn btn-primary pull-right']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	@endforeach
</div>
