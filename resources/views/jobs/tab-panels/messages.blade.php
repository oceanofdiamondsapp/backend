@foreach ($job->messages as $message)
	<div class="row">
		<div class="col-xs-10 {{ $message->user->hasRole('USER') ? '' : 'col-xs-offset-2' }}">
			<div class="panel panel-default">
				<div class="panel-body">
					<span class="{{ $message->user->hasRole('USER') ? 'text-success' : 'text-primary' }}">
						<strong>{{ $message->user->name }} on {{ $message->created_at->format('n/j/y g:i A') }}</strong>: {{ $message->body }}
					</span>

					@if (count($message->images) > 0)
						<hr>
						
						<div class="row">
							@foreach ($message->images as $image)
								<div class="col-sm-3">
									<a href="{{ $image->path }}" class="magnific">
										<img src="{{ $image->path }}" alt="" class="img-responsive">
									</a>
								</div>
							@endforeach
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endforeach

{!! Form::open(['route' => ['jobs.messages.store', $job->id], 'enctype' => 'multipart/form-data']) !!}
	<div class="form-group">
		{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::file('images[]', ['class' => 'form-control', 'multiple']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Send', ['class' => 'btn btn-primary pull-right']) !!}
	</div>
{!! Form::close() !!}