@unless (count($job->quotes))
	<p>There are no quotes.</p>
@endunless

<ul class="list-unstyled">
	@foreach ($job->quotes as $quote)
		<li>
			<a href="#{{ $quote->quote_number }}" data-toggle="subpanel">
				{{ $quote->quote_number }} - {{ $quote->status->description }} {{ $quote->created_at->format('n/j/y') }} by {{ $quote->user->name }}
			</a>
		</li>
	@endforeach
</ul>

<div class="tab-content">
	@foreach ($job->quotes as $quote)
		<div class="tab-pane" id="{{ $quote->quote_number }}" data-subpanel-id="{{ $quote->quote_number }}">
			<a href="#" data-close="subpanel" data-target-pane-id="quotes" class="pull-right text-danger">
				<i class="fa fa-2x fa-times-circle"></i>
			</a>

			<h4>Quote: {{ $quote->quote_number }}</h4>

			<p>{{ $quote->status->description }} {{ $quote->created_at->format('n/j/y') }} by {{ $quote->user->name }}</p>

			<!-- <div class="form-group">
				<a class="btn btn-primary">Print</a>
				<a class="btn btn-primary">PDF</a>
				<a class="btn btn-primary">Duplicate</a>
			</div> -->

			<p>
				<strong>Jewelry Type</strong><br>
				{{ $quote->jewelryType->description }}
			</p>

			<p>
				<strong>Description</strong><br>
				{{ $quote->description }}
			</p>

			<p>
				<strong>Gemstones</strong><br>
				{{ $quote->stones_description }}
			</p>

			<p>
				<strong>Metals</strong><br>
				{{ $quote->metals_description }}
			</p>

			<p>
				<strong>Details</strong><br>
				Setting: {{ $quote->setting_details }}<br>
				Size: {{ $quote->size_details }}
			</p>

			<p>
				<strong>Other Details</strong><br>
				{{ $quote->other_details }}
			</p>

			@if ($quote->decline_type_id)
				<p>
					<strong>Decline Reason:</strong><br>
					{{ $quote->declineType->description }}
				</p>
			@endif

			<hr>

			<p>
				<strong>Price</strong> <small>(Only total price and tax amount is shown to the client)</small><br>
				Piece: {{ $quote->price_formatted }}<br>
				Tax: {{ $quote->tax_due_formatted }} ({{ $quote->tax->description }})<br>
				Shipping: {{ $quote->shipping_formatted }}<br>
			</p>

			<ul class="list-inline">
				<li><strong>Quote</strong></li>
				<li><span class="text-xl">{{ $quote->total_due_formatted }}</span></li>
			</ul>

			<hr>

			<p><strong>Internal Notes</strong> <small>(Not visible to the client)</small></p>

			@foreach ($quote->notes as $note)
				<div class="panel panel-default">
					<div class="panel-body">
						<strong>{{ $note->user->name }} on {{ $note->created_at->format('n/j/y g:i A') }}</strong><br>
						{!! nl2br($note->body) !!}
					</div>
				</div>
			@endforeach

			@unless (count($quote->notes))
				<p>There are no notes</p>
			@endunless

			{!! Form::open(['route' => ['quotes.notes.store', $quote->id]]) !!}
				<div class="form-group">
					{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group clearfix">
					{!! Form::submit('Add Note', ['class' => 'btn btn-primary pull-right']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	@endforeach
</div>
