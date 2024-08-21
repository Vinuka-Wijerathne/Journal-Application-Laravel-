<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to My Journal</title>
    @vite(['resources/css/home.css']) <!-- Link to the CSS file -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="full-page-container">
        <header class="header">
            <img src="{{ asset('images/logo.png') }}" alt="App Logo" class="logo"> <!-- Larger logo -->
            <h1>Welcome to My Journal</h1>
            <p class="description">My Journal helps you capture and reflect on your thoughts every day. Keep your daily entries safe and secure with our simple and intuitive interface.</p>
        </header>

        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn login-btn">Login</a>
            <a href="{{ route('register') }}" class="btn signup-btn">Sign Up</a>
        </div>
    </div>
</body>
</html>
