<h3>{{ $account->name }}</h3>

<ul class="list-unstyled">
	<li><strong>Email:</strong> {{ $account->email }}</li>
	<li><strong>Member since:</strong> {{ $account->created_at->format('M, j, Y') }}</li>
</ul>

<ul class="list-unstyled">
	<li><strong>Last quote:</strong> {{ $account->last_quote_date }}</li>
	<li><strong>Last order:</strong> {{ $account->last_order_date }}</li>
	<li><strong>Quotes:</strong> {{ $account->quotes->count() }}</li>
	<li><strong>Orders:</strong> {{ $account->orders->count() }}</li>
	<li><strong>Percentage success:</strong> Todo</li>
	<li><strong>Total spend:</strong> {{ $account->total_spent }}</li>
</ul>

<p><strong>Notes:</strong></p>

@foreach ($account->notes as $note)
	<p>
		<strong>{{ $note->user->name }} {{ $note->created_at->format('n/d/y') }}:</strong> {{ $note->body }}
		@if ($note->user->id == Auth::user()->id)
			<a href="#" class="small">Edit</a> <a href="#" class="small">Delete</a>
		@endif
	</p>
@endforeach

@unless ( count($account->notes) )
	<p>There are no notes.</p>
@endunless