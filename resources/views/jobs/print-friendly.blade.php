<div class="hidden print-friend">
	<h1 class="page-header">Ocean of Diamonds</h1>

	<div class="page-subheader clearfix">
		<div class="pull-left">
			<strong>Job: {{ $job->job_number }}</strong>
		</div>

		<div class="pull-right">
			<strong>Printed:</strong> {{ date('n/d/y') }}
		</div>
	</div>

	<h4>{{ $job->account->name }}</h4>

	<ul class="list-unstyled">
		<li><strong>Email:</strong> {{ $job->account->email }}</li>
	</ul>

	<ul class="list-unstyled">
		<li><strong>Client reference:</strong> {{ $job->nickname }}</li>
		<li><strong>Submitted:</strong> {{ $job->created_at->format('M j, Y') }}</li>
		<li><strong>Deadline:</strong> {{ $job->deadline->format('M, j, Y') }}</li>
	</ul>

	<ul class="list-unstyled">
		<li><strong>Metals:</strong> {{ $job->comma_separated_metal_list }}</li>
		<li><strong>Stone:</strong> {{ $job->comma_separated_stone_list }}</li>
		<li><strong>Price range:</strong> {{ $job->budget_formatted }}</li>
		<li><strong>Shipping to:</strong> {{ $job->ship_to_state }}</li>
	</ul>

	<ul class="list-unstyled">
		<li><strong>Notes:</strong> {{ $job->notes }}</li>
	</ul>

	<div class="mt40">
		@foreach ($job->images as $image)
			<img src="{{ $image->path }}" class="pull-left" width="300">
		@endforeach
	</div>
</div>