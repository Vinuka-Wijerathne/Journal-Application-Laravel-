<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/topbar.css','resources/css/home.css', 'resources/css/login.css',
     'resources/css/register.css','resources/css/journal-form.css','resources/css/calender.css',
     'resources/css/verify-email.css','resources/css/dashboard.css','resources/css/create.css'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</head>
<body class="antialiased">
    <!-- Include the topbar component here -->
    

    <!-- Main content of the page -->
    <div class="container mx-auto">
        {{ $slot }}
    </div>
</body>
</html>
