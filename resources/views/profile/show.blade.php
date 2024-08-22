<x-layout>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <x-topbar /> <!-- Include the top bar -->

    <div class="profile-container">
        <div class="profile-header">
            <h1>{{ auth()->user()->name }}'s Profile</h1>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="profile-details">
                <div class="profile-info">
                    <h2>Personal Information</h2>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio:</label>
                        <textarea id="bio" name="bio">{{ auth()->user()->bio }}</textarea>
                    </div>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Joined:</strong> {{ auth()->user()->created_at->format('F d, Y') }}</p>
                </div>
                <div class="profile-avatar">
                    <img id="avatar-preview" src="{{ asset('storage/' . auth()->user()->avatar) }}?{{ time() }}" alt="Avatar" class="avatar">

                    <label for="avatar-input" class="btn-primary-upload">Choose Image</label>
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>
            <button type="submit" class="btn-primary-edit">Update Profile</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('avatar-preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result; // Set the image source to the selected file
            }

            if (file) {
                reader.readAsDataURL(file); // Read the selected file as a data URL
            } else {
                // If no file is selected, reset to the default image
                preview.src = '{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/profile.png') }}';
            }
        }
    </script>
</x-layout>
