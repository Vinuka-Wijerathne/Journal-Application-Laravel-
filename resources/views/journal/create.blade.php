<x-layout>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <x-topbar />

    <div class="form-container">
        <h1>Create a New Journal Entry</h1>

        <form action="{{ route('journal.store') }}" method="POST" enctype="multipart/form-data"> <!-- Add enctype for file uploads -->
            @csrf

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="{{ $defaultDate }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" id="content" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image (optional):</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Save Entry</button>
        </form>
    </div>
</x-layout>
