<div class="topbar">
    <div class="logo">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('images/journaling.png') }}" alt="My App Logo" class="logo-image"> My Journal
        </a>
    </div>
    <div class="menu">
        <a href="{{ route('profile.show') }}" class="menu-item">
            <img 
                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile.png') }}" 
                alt="Profile" 
                class="profile-icon">
        </a>
        
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</div>
