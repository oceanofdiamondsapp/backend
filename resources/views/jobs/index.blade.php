@extends('app')

@section('content')
	<div class="page-header">
		<h1>Jobs</h1>
	</div>

	<ul class="list-inline mb30">
		<li>Filter By:</li>
		<li>
			<a href="/jobs" class="btn {{ !Request::has('status_id') ? 'btn-primary' : 'btn-default' }}">All</a>
		</li>
		<li>
			<a href="/jobs?status_id=1" class="btn {{ Request::get('status_id') == 1 ? 'btn-primary' : 'btn-default' }}">Request ({{ $queryCount[1] }})
			</a>
		</li>
		<li>
			<a href="/jobs?status_id=3" class="btn {{ Request::get('status_id') == 3 ? 'btn-primary' : 'btn-default' }}">Quoted ({{ $queryCount[3] }})
			</a>
		</li>
		{{--<li>--}}
			{{--<a href="/jobs?status_id=2" class="btn {{ Request::get('status_id') == 2 ? 'btn-primary' : 'btn-default' }}">Saved ({{ $jobs->where('status_id', 2)->count() }})--}}
			{{--</a>--}}
		{{--</li>--}}
		<li>
			<a href="/jobs?status_id=4" class="btn {{ Request::get('status_id') == 4 ? 'btn-primary' : 'btn-default' }}">Lapsed ({{ $queryCount[4] }})
			</a>
		</li>
		<li>
			<a href="/jobs?status_id=5" class="btn {{ Request::get('status_id') == 5 ? 'btn-primary' : 'btn-default' }}">Declined ({{ $queryCount[5] }})
			</a>
		</li>
	</ul>

	<table id="datatable" class="table table-bordered table-striped text-center">
		<thead>
			<tr>
				<th class="text-center">Action</th>
				<th class="text-center">Job Number</th>
				<th class="text-center">Customer</th>
				<th class="text-center">Nickname</th>
				<th class="text-center">Submitted</th>
				<th class="text-center">Update</th>
				<th class="text-center"><i class="fa fa-envelope"></i></th>
				<th class="text-center"><i class="fa fa-exclamation-triangle"></i></th>
				<th class="text-center">Status</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($jobs as $job)
				<tr>
					<td><a href="/jobs/{{ $job->id }}" class="btn btn-default btn-xs">View</a></td>
					<td>{{ $job->job_number }}</td>
					<td>{{ $job->account->name }}</td>
					<td>{{ $job->nickname }}</td>
					<td>{{ $job->created_at->format('n/j/y') }}</td>
					<td>{{ $job->updated_at->format('n/j/y') }}</td>
					<td>
						@if ($job->has_unread_messages == 0)
						@elseif ($job->has_unread_messages == 1)
							<i class="fa fa-envelope"></i>
						@else
							<i class="fa fa-envelope" style="color:rgb(255,80,80);"></i>
						@endif
					</td>
					<td>{!! $job->is_expiring_soon ? '<i class="fa fa-exclamation-triangle text-warning"></i>' : '' !!}</td>
					<td>{{ $job->status->description }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
