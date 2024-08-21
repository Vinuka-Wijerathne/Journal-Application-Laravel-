<x-layout>
    <x-topbar />

    <div class="dashboard-container">
        <h1>Your Journal Entries</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($journalEntries->isEmpty())
            <p>You have no journal entries yet. Start writing your thoughts!</p>
        @else
            <ul>
                @foreach($journalEntries as $entry)
                    <li>
                        <strong>{{ \Carbon\Carbon::parse($entry->date)->format('F j, Y') }}:</strong> 
                        {{ $entry->content }}
                        <a href="{{ route('journal.edit', $entry->id) }}" class="btn-edit">Edit</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <a href="{{ route('journal.create') }}" class="btn-write">Write a New Journal Entry</a>
</x-layout>
