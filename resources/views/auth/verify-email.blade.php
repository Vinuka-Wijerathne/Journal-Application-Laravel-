<x-layout>
    <div class="verification-container">
        <div class="verification-content">
            <h2>Please Verify Your Email Address</h2>
            <lottie-player src="{{ asset('images/verify-email.json') }}" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
            <p>A verification email has been sent to your email address. Please check your inbox and click on the verification link to activate your account.</p>
            <button class="btn-primary-verify" onclick="redirectToEmail()">Verify Email</button>
        </div>
    </div>

    <script>
        function redirectToEmail() {
            // This will attempt to open the user's default email client.
            window.location.href = "mailto:youremail@example.com";
        }
    </script>
</x-layout>
