<html>
<head>
	<title>Ocean of Diamonds</title>
	<style type="text/css">
		html, body {
			font-family: Helvetica, Arial, sans-serif;
		}
	</style>
</head>
<body>
	<div style="text-align: center;">
		<h1>You Have a New Quote</h1>
	</div>

	<p style="text-align: center;">
		A new quote has been created for you.<br>
		Log into your account to view more details.
	</p>

	<p style="text-align: center;">
		<strong>Nickname:</strong> {{ $quote->job->nickname }}<br>
		<strong>Quote Number:</strong> {{ $quote->quote_number }}<br>
		<strong>Created By:</strong> {{ Auth::user()->name }}<br>
		<strong>Created On:</strong> {{ $quote->created_at->format('F d, Y') }}<br>
		<strong>Expires:</strong> {{ $quote->expires_at->format('F d, Y') }}
	</p>
</body>
</html>
