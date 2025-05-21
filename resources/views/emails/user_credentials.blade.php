<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Login Credentials</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>Welcome to our platform! Below are your login credentials:</p>
    <table>
        <tr>
            <td><strong>Username:</strong></td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td><strong>Password:</strong></td>
            <td>{{ $password }}</td>
        </tr>
    </table>
    <p>Thank you for joining us!</p>
</body>
</html>
