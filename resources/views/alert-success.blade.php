@if (Session::get('success'))
	<ul class="list-unstyled alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<li>{{ Session::get('success') }}</li>
	</ul>
@endif