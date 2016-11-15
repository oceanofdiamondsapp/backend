<div class="hidden {{'print-wild'.$order->order_number}}">
	<h1 class="page-header">Ocean of Diamonds</h1>

	<div class="page-subheader clearfix">
		<div class="pull-left">
			<strong>Job: {{ $job->job_number }}</strong>
		</div>

		<div class="pull-right">
			<strong>Printed:</strong> {{ date('n/d/y') }}
		</div>
	</div>

	<div>
		<h4>Order: {{ $order->order_number }}</h4>

		<p>Ordered {{ $order->created_at->format('n/d/y') }}</p>

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

	</div>
</div>