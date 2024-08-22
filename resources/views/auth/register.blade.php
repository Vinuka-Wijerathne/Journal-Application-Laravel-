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

        <div class="register-box">
            <div class="register-form">
                <h2>Register</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn-primary-register" id="register-button">
                        Register
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                    </button>
                    <p>Already have an account? <a href="{{ route('login') }}" class="link">Login</a></p>
                </form>
            </div>

            <div class="register-image">
                <div class="image-text">
                    <h1>Get started!</h1>
                    <img src="{{ asset('images/logo.png') }}" alt="App Logo" class="logo"> <!-- Larger logo -->
                    <p>Welcome to My Journal, your go-to personal journal app where you can keep track of your daily thoughts and experiences. Start your journey with us today!</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const registerButton = document.getElementById('register-button');
            const spinner = registerButton.querySelector('.spinner-border');

            form.addEventListener('submit', function() {
                // Show the spinner and change button text
                registerButton.disabled = true; // Disable the button
                registerButton.innerHTML = 'Registering...'; // Change button text
                spinner.style.display = 'inline-block'; // Show the spinner
            });
        });
    </script>
</x-layout>
