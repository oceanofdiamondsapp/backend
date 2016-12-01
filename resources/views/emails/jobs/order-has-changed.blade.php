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
		<h1>Order Status was changed by Ocean of Diamonds</h1>
	</div>

	<p style="text-align: center;">
		{{ $msg }}
	</p>

	<p style="text-align: center;">
		<strong>Sent By:</strong> {{ Auth::user()->name }}
	</p>
</body>
</html>