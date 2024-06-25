<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access Granted for {{ config('app.name') }}</title>
</head>
<body>
  <div style="padding: 20px; background-color: #f5f5f5;">
    <h1>Hi {{ $name }},</h1>
    <p>This email confirms that you have been granted access to {{ config('app.name') }}.</p>

    <h2>Login Details:</h2>
    <ul>
      <li>Username: {{ $username ?? 'N/A' }}</li>
      <li>Password: {{ $password ?? 'N/A' }}</li>
    </ul>

    <p>Please follow these steps to set your password:</p>
    <ol>
      <li>Visit the login page: <a href="{{ route('login') }}">Login</a></li>
      <li>Enter your username and password to login</li>
    </ol>

    <p>We're excited to have you on board!</p>

    <p>Sincerely,</p>
    <p>The {{ config('app.name') }} Team</p>
  </div>
</body>
</html>