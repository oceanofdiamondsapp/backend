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

				<h2 class="text-center mt0 mb30">Reset Password</h2>
				
				<form class="form-horizontal" role="form" method="POST" action="{{ url('auth/password/reset') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="token" value="{{ $token }}">

					{{--<div class="form-group">--}}
						{{--<label class="col-md-4 control-label">E-Mail Address</label>--}}
						{{--<div class="col-md-6">--}}
							{{--<input type="email" class="form-control" name="email" value="{{ old('email') }}">--}}
						{{--</div>--}}
					{{--</div>--}}

					<div class="form-group">
						<label class="col-md-4 control-label">Password</label>
						<div class="col-md-6">
							<input type="password" class="form-control" name="password">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label">Confirm Password</label>
						<div class="col-md-6">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn btn-primary">
								Reset Password
							</button>
						</div>
					</div>
				</form>
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
