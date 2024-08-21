<x-layout>
    <div class="register-container">
        @if ($errors->any())
            <div class="error-popup">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="login-container">
        <div class="login-box">
            <div class="login-form">
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="remember_me">
                            <input type="checkbox" id="remember_me" name="remember">
                            Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn-primary-login">Login</button>
                    <a href="{{ route('password.request') }}" class="link">Forgot your password?</a>
                </form>
                <p>Don't have an account? <a href="{{ route('register') }}" class="link">Register</a></p>
            </div>

            <div class="login-image">
                <div class="image-text">
                    <h1>Welcome Back!</h1>
                    <img src="{{ asset('images/journaling.png') }}" alt="App Logo" class="logo"> <!-- Larger logo -->
                    <p>We missed you! Log in to continue your journey with My Journal and keep track of your thoughts and experiences.</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
