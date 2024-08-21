<!-- resources/views/journal/edit.blade.php -->

<x-layout>
    <x-topbar />

    <div class="journal-edit-container">
        <h1>Edit Journal Entry for {{ $journalEntry->date->format('F j, Y') }}</h1>

        <form method="POST" action="{{ route('journal.update', $journalEntry->id) }}">
            @csrf
            @method('PUT') <!-- Specify the PUT method for update -->
            <div class="form-group">
                <textarea name="content" rows="10" required>{{ $journalEntry->content }}</textarea>
            </div>
            <button type="submit" class="btn-primary">Update Journal</button>
        </form>
    </div>
</x-layout>
