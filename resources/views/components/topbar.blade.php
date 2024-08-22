<div class="topbar bg-gray-800 p-4 text-white flex justify-between items-center">
    <div class="logo">
        <a href="{{ url('/') }}" class="text-2xl font-bold">
            <img src="{{ asset('images/logo.png') }}" alt="My App Logo" class="logo-image"> My Journal
        </a>
    </div>
    <div class="menu flex items-center">
        <a href="{{ url('/') }}" class="mr-4">Home</a>
        <a href="{{ route('profile.show') }}" class="mr-4">
            <img src="{{ asset('images/profile-icon.png') }}" alt="Profile" class="profile-icon">
        </a>
        <a href="{{ route('logout') }}" class="mr-4">Logout</a>
    </div>
</div>
