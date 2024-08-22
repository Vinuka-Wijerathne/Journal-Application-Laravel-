<div class="topbar">
    <div class="logo">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('images/journaling.png') }}" alt="My App Logo" class="logo-image"> My Journal
        </a>
    </div>
    <div class="menu">
        <!-- Dynamic Greeting Message -->
        <span id="greeting"></span> <!-- Element for greeting message -->

        <a href="{{ route('profile.show') }}" class="menu-item">
            <img 
                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile.png') }}" 
                alt="Profile" 
                class="profile-icon">
        </a>

        <!-- Menu Icon -->
        <div class="menu-dropdown">
            <button class="menu-icon">☰</button>
            <div class="dropdown-content">
                <a href="{{ route('journal.dashboard') }}">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-menu-item">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include this script at the bottom of your Blade template -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        const hours = now.getUTCHours() + 5; // Adjust for UTC+5:30
        const minutes = now.getUTCMinutes();
        
        // Adjust for minutes
        const adjustedHours = (hours + (minutes / 60)) % 24;

        let greeting = '';
        if (adjustedHours < 12) {
            greeting = 'Good Morning';
        } else if (adjustedHours < 17) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }

        const username = '{{ Auth::user()->name }}'; // Access the username
        const greetingElement = document.getElementById('greeting'); // Element for greeting message
        greetingElement.textContent = `${greeting}, ${username}!`;
    });
</script>
