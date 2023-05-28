<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>
<body>
    <h4>Welcome to Habiclothiers {{ $user->fullname }}, click the button below to verify your email address</h4>
    
    <p>Your verification code is <b>{{ $verifyEmail->code }}</b> and will expire in {{ \Carbon\Carbon::parse($verifyEmail->expires_in) }}</p>
</body>
</html>