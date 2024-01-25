<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
<h2>Password Reset Token</h2>

<p>Dear user,</p>
<p>We have received a request to reset your password. Please use the following token:</p>

<h3>{{ $token }}</h3>

<p>Enter this token on the password reset page to proceed. If you didn't request a password reset, you can ignore this email.</p>

<p>Thank you.</p>
</body>
</html>
