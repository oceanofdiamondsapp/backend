<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ocean of Diamonds</title>

	<link href="{{ asset('/css/all.css') }}" rel="stylesheet">
	{{--<link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">--}}
	<link href="{{asset('/tempSC/dataTables.bootstrap.css')}}" rel="stylesheet">

	<!-- Fonts -->
	{{--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>--}}
	<link href='{{asset("/tempSC/Roboto.css")}}' rel='stylesheet' type='text/css'>
	{{--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">--}}
	<link href="{{asset('/tempSC/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	{{--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>--}}
	{{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
	<!--[if lt IE 9]>

		<script src="{{asset('/tempSC/html5shiv.min.js')}}"></script>
		<script src="{{asset('/tempSC/respond.min.js')}}"></script>

	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<img src="/img/logo-ocean-of-diamonds-415x66.png" alt="Ocean of Diamonds" class="navbar-logo">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				@if (Auth::user())
					<ul class="nav navbar-nav">
						<li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Dashboard</a></li>
						<li class="{{ Request::is('jobs*') ? 'active' : '' }}"><a href="{{ url('/jobs') }}">Jobs</a></li>
						<li class="{{ Request::is('orders*') ? 'active' : '' }}"><a href="{{ url('/orders') }}">Orders</a></li>
						<li class="{{ Request::is('accounts*') ? 'active' : '' }}"><a href="{{ url('/accounts') }}">Accounts</a></li>
					</ul>
				@endif

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<!-- <li><a href="{{ url('/settings') }}">Settings</a></li> -->
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		@yield('content')
	</div>

	<!-- Scripts -->
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
	{{--<script src="//cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>--}}
	{{--<script src="//cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>--}}
	{{--<script src="/js/all.js"></script>--}}

	<script src="{{asset('/tempSC/jquery.min.js')}}"></script>
	<script src="{{asset('/tempSC/bootstrap.min.js')}}"></script>
	<script src="{{asset('/tempSC/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/tempSC/dataTables.bootstrap.js')}}"></script>
	<script src="/js/all.js"></script>
</body>
</html>
