@extends('basic')

@section('content')
	<div class="row mt80">
		<div class="col-sm-6 col-sm-offset-3">
			<img src="/img/logo-ocean-of-diamonds-415x66.png" class="img-responsive center-block">
		</div>
	</div>

	<div class="row mt20">
		<div class="col-sm-6 col-sm-offset-3">

			@if ($errors->any())
				<ul class="list-unstyled text-center text-danger">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif

			<div class="panel panel-simple">
				<div class="panel-body panel-body-lg">

					<h2 class="text-center mt0 mb30">Login</h2>
					
					{!! Form::open(['class' => 'form-horizontal']) !!}
						<div class="form-group {{ !$errors->has('email') ?: 'has-error' }}">
							{!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								{!! Form::text('email', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group {{ !$errors->has('password') ?: 'has-error' }}">
							{!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							{!! Form::submit('Submit', ['class' => 'btn btn-primary center-block']) !!}
						</div>

						<div class="text-center">
							<a href="/password/email">Forgot your password?</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<p class="text-center">If you are a new user, please email<br><a class="text-blue" href="mailto:info@oceanofdiamondsapp.com">info@oceanofdiamondsapp.com</a><br>to be set up in the system.</p>
		</div>
	</div>
@endsection
