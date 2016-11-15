{{--<html>--}}
{{--<body>--}}
{{--<a href="{{ env("APP_URL").'password/reset/'.$token }}">Click here to reset your password</a>--}}
{{--</body>--}}
{{--</html>--}}

<html>
<body>
<h3 style = "font-weight: bold;">Forgot Your Password?</h3><br>
Hi<br><br>

As requested, here is the link to reset your Ocean of Diamonds password. This link will expire in 24 hours.<br><br>

<a href="{{ env("APP_URL").'password/reset/'.$token }}">Click here to reset your password</a><br><br>

Please note that you can change password only one time by this link.<br>
If you didn't request, please ignore this.<br><br>

Thanks,<br>
Ocean of Diamonds Team<br>
</body>
</html>