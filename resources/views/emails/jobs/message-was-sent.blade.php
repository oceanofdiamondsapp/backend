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
		<h1>New Message from Ocean of Diamonds</h1>
	</div>

	<p style="text-align: center;">
		{{ $msg->body }}
	</p>

	<p style="text-align: center;">
		<strong>Sent By:</strong> {{ Auth::user()->name }}
	</p>

	<p style="text-align: center;">Do not reply to this email. To respond, log into your Ocean of Diamonds account on iOS or Android.</p>
</body>
</html>