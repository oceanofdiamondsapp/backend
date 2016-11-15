@foreach ($job->events->groupBy('created_on_date') as $date => $events)
	<h5>{{ date('F j, Y', strtotime($date)) }}</h5>

	@foreach ($events as $event)
		<ul class="list-unstyled">
			<li>
				{{ $event->created_at->format('g:i A') }} - {{ $event->description }} {{ $event->user->name }}
			</li>
		</ul>
	@endforeach
@endforeach

@unless (count($job->events))
	<p>There are no events.</p>
@endunless