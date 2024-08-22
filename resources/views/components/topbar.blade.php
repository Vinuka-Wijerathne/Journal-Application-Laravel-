<div class="topbar">
    <div class="logo">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('images/journaling.png') }}" alt="My App Logo" class="logo-image"> My Journal
        </a>
    </div>
    <div class="menu">
        <a href="{{ url('/') }}" class="menu-item">Home</a>
        <a href="{{ route('profile.show') }}" class="menu-item">
            <img src="{{ asset('images/profile.png') }}" alt="Profile" class="profile-icon">
        </a>
        <a href="{{ route('logout') }}" class="menu-item">Logout</a>
    </div>
</div>
