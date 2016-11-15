@extends('app')

@section('content')
	<div class="visible-print-block"></div>

	<div class="hidden-print">
		@include('jobs.print-friendly')
		@include('errors.list')
		@include('alert-success')

		<div class="page-header">
			<h1>Job: {{ $job->job_number }}</h1>
		</div>

		<div class="row">
			<div class="col-sm-6 col-lg-4">
				<div id="slider-container" style="position: relative; top: 0px; left: 0px; width: 360px; height: 360px; margin-bottom: 20px;">
					<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 360px; height: 360px;">
						@if ( ! $job->images->count())
							No images
						@endif

						@foreach ($job->images as $image)
							<div><img src="{{ $image->path }}" class="img-responsive thumbnail"></div>
						@endforeach
					</div>
				</div>

				<h4>Quote Details</h4>

				<ul class="list-unstyled">
					<li><strong>Client reference:</strong> {{ $job->nickname }}</li>
					<li><strong>Submitted:</strong> {{ $job->created_at->format('M j, Y') }}</li>
					<li><strong>Update:</strong> {{ $job->updated_at->format('M, j, Y') }}</li>
				</ul>

				<ul class="list-unstyled">
					<li><strong>Metals:</strong> {{ $job->comma_separated_metal_list }}</li>
					<li><strong>Stone:</strong> {{ $job->comma_separated_stone_list.' - '.$job->carat.'ct' }}</li>
					<li><strong>Price range:</strong> {{ $job->budget_formatted }}</li>
					<li><strong>Deadline:</strong> {{ $job->deadline->format('M, j, Y') }}</li>
					<li><strong>Shipping to:</strong> {{ $job->ship_to_state }}</li>
				</ul>

				<ul class="list-unstyled">
					<li><strong>Notes:</strong> {{ $job->notes }}</li>
				</ul>

				<div class="mb30">
					<a href="#" id="print-friend" class="btn btn-primary btn-xs" onclick="onPrintFriend(this)">Print</a>
					<!-- <a href="#" class="btn btn-primary btn-xs">PDF</a> -->
				</div>

				<h4>Client Details</h4>

				<ul class="list-unstyled">
					<li><strong>Name:</strong> <a href="{{ url('/accounts/'.$job->account->id) }}">{{ $job->account->name }}</a> </li>
					<li><strong>Email:</strong> <a href="{{ url('/accounts/'.$job->account->id) }}">{{ $job->account->email }}</a></li>
					<li><strong>Last quote:</strong> {{ $job->account->last_quote_date }}</li>
					<li><strong>Last order:</strong> {{ $job->account->last_order_date }}</li>
					<li><strong>Quotes:</strong> {{ $job->account->quotes->count() }}</li>
					<li><strong>Total spend:</strong> {{ $job->account->total_spent }}</li>
				</ul>
			</div>

			<div class="col-sm-6 col-lg-8">
				<p><strong>Status:</strong> {{ $job->status->description }}</p>

				<div role="tabpanel">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
						<li role="presentation"><a href="#quotes" aria-controls="quotes" role="tab" data-toggle="tab">Quotes</a></li>
						<li role="presentation"><a href="#create-quote" aria-controls="create-quote" role="tab" data-toggle="tab">New Quote</a></li>
						@if ($job->has_orders)
							<li role="presentation"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Orders</a></li>
						@endif
						<li role="presentation"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Events</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="messages">@include('jobs.tab-panels.messages')</div>
						<div role="tabpanel" class="tab-pane" id="quotes">@include('jobs.tab-panels.quotes')</div>
						<div role="tabpanel" class="tab-pane" id="create-quote">@include('jobs.tab-panels.create-quote')</div>
						@if ($job->has_orders)
							<div role="tabpanel" class="tab-pane" id="orders">@include('jobs.tab-panels.orders')</div>
						@endif
						<div role="tabpanel" class="tab-pane" id="events">@include('jobs.tab-panels.events')</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function onPrintFriend(obj)
		{
			var className = $(obj).attr('id');
			var $dom = $("." + className);

			$('.visible-print-block').empty();
			$('.visible-print-block').html($dom.html());
			window.print();
		}
	</script>
@endsection