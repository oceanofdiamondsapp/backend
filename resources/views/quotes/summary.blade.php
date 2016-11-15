<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Action</th>
				<th>Quote Number</th>
				<th>Customer</th>
				<th>Description</th>
				<th>Start</th>
				<th>Update</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($quotes as $quote)
				<tr>
					<td><a href="/quotes/{{ $quote->id }}" class="btn btn-default btn-xs">View</a></td>
					<td>{{ $quote->quote_number }}</td>
					<td>{{ $quote->request->account->name }}</td>
					<td>{{ $quote->description }}</td>
					<td>{{ $quote->created_at->format('n/j/y') }}</td>
					<td>{{ $quote->updated_at->format('n/j/y') }}</td>
					<td>{{ $quote->status->status }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>