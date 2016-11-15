@extends('app')

@section('content')
	<div class="page-header">
		<h1>Accounts</h1>
	</div>

	<div class="row">
		<div class="col-lg-3">
			@include('alert-success')
			@include('errors.list')
			@include('accounts.summary')

			{!! Form::open(['route' => ['accounts.notes.store', $account->id]]) !!}
				<div class="form-group">
					{!! Form::label('body', 'Add a Note:') !!}
					{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				</div>
			{!! Form::close() !!}
		</div>

		<div class="col-lg-9">
			<table id="datatable" class="table table-bordered table-striped text-center">
				<thead>
					<tr>
						<th class="text-center">Action</th>
						<th class="text-center">Job Number</th>
						<th class="text-center">Nickname</th>
						<th class="text-center">Submitted</th>
						<th class="text-center">Update</th>
						<th class="text-center"><i class="fa fa-envelope"></i></th>
						<th class="text-center"><i class="fa fa-exclamation-triangle"></i></th>
						<th class="text-center">Status</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($account->jobs as $job)
						<tr>
							<td><a href="/jobs/{{ $job->id }}" class="btn btn-default btn-xs">View</a></td>
							<td>{{ $job->job_number }}</td>
							<td>{{ $job->nickname }}</td>
							<td>{{ $job->created_at->format('n/j/y g:i A') }}</td>
							<td>{{ $job->updated_at->format('n/j/y g:i A') }}</td>
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
		</div>
	</div>
@endsection