<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Password Reset</h2>

<div>
    Click here to reset your password: <a href="{{$link=url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset())}}"> {{$link}} </a>
</div>
</body>
</html>