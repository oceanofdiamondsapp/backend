@extends('app')

@section('content')
	<div class="page-header">
		<h1>Accounts</h1>
	</div>

	<table id="datatable" class="table table-bordered text-center">
		<thead>
			<tr>
				<th class="text-center">Action</th>
				<th class="text-center">Name</th>
				<th class="text-center">Email</th>
				<th class="text-center">Member Since</th>
				<th class="text-center">Last Activity</th>
				<th class="text-center">Quotes</th>
				<th class="text-center">Orders</th>
				<th class="text-center">Total Spent</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($accounts as $account)
				<tr>
					<td><a href="/accounts/{{ $account->id }}" class="btn btn-default btn-xs">View</a></td>
					<td>{{ $account->name }}</td>
					<td>{{ $account->email }}</td>
					<td>{{ $account->created_at->format('n/j/y') }}</td>
					<td>{{ $account->updated_at->format('n/j/y') }}</td>
					<td>{{ $account->quotes->count() }}</td>
					<td>{{ $account->orders->count() }}</td>
					<td>{{ $account->total_spent }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection