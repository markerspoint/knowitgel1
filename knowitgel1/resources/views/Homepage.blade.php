<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h1>Welcome to KnowItGel1</h1>
        <p class="lead">Join us now by registering an account or logging in.</p>
        
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-lg mx-2">Register</a>
        </div>
    </div>
</body>
</html>
