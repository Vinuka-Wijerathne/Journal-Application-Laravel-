<!-- resources/views/journal/dashboard.blade.php -->

<x-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <x-topbar /> <!-- Include the top bar -->

    <div class="dashboard-container">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>

        <div class="journals">
            <h2>Your Journal Entries</h2>

            @if($journalEntries->isEmpty())
                <p>You have no journal entries yet. Start writing your thoughts!</p>
            @else
                <ul>
                    @foreach($journalEntries as $entry)
                        <li>
                            <strong>{{ $entry->date->format('F j, Y') }}:</strong> {{ $entry->content }}
                            <a href="{{ route('journal.edit', $entry->id) }}" class="btn-edit">Edit</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <a href="{{ route('journal.create') }}" class="btn-write">Write a New Journal Entry</a>
    </div>
</x-layout>
