<x-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <x-topbar />

    <div class="dashboard-container">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>

        <!-- Search Form -->
        <div class="search-container">
            <form method="GET" action="{{ route('journal.search') }}">
                <input type="text" name="query" placeholder="Search by date or content" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Filter for Favorite Entries -->
        <div class="filter-favorites">
            <form method="GET" action="{{ route('journal.favorites') }}">
                <button type="submit">Show Favorite Entries</button>
            </form>
        </div>

        <div class="journals">
            <h2>Your Journal Entries</h2>

            @if($journalEntries->isEmpty())
                <p>You have no journal entries yet. Start writing your thoughts!</p>
            @else
                <ul>
                    @foreach($journalEntries as $entry)
                        <li class="journal-entry">
                            <div class="journal-header">
                                <strong>{{ \Carbon\Carbon::parse($entry->date)->format('F j, Y') }}:</strong>
                                <!-- Delete Icon -->
                                <button type="button" class="btn-delete-icon" onclick="confirmDelete({{ $entry->id }})">
                                    🗑️
                                </button>

                                <!-- Confirmation Popup -->
                                <div id="delete-confirmation-{{ $entry->id }}" class="confirmation-popup">
                                    <p>Are you sure you want to delete this entry?</p>
                                    <form action="{{ route('journal.destroy', $entry->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-confirm">Yes</button>
                                        <button type="button" class="btn-cancel" onclick="closePopup({{ $entry->id }})">No</button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Render the first few lines of the content -->
                            <div class="journal-content">
                                @php
                                    $contentBlocks = json_decode($entry->content, true);
                                    $displayedContent = '';
                                    $lineCount = 0;
                                    $maxLines = 3;
                                @endphp

                                @if(is_array($contentBlocks) && isset($contentBlocks['blocks']))
                                    @foreach($contentBlocks['blocks'] as $block)
                                        @if($block['type'] == 'paragraph' && $lineCount < $maxLines)
                                            @php
                                                $text = $block['data']['text'];
                                                $displayedContent .= $text . ' ';
                                                $lineCount++;
                                            @endphp
                                        @elseif($block['type'] == 'list' && $lineCount < $maxLines)
                                            <ul>
                                                @foreach($block['data']['items'] as $item)
                                                    @php
                                                        $displayedContent .= $item . ' ';
                                                        $lineCount++;
                                                        if($lineCount >= $maxLines) break;
                                                    @endphp
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if($lineCount >= $maxLines) break;
                                        @endif
                                    @endforeach
                                @endif
                                
                                <p>{{ Str::limit($displayedContent, 150) }}...</p>
                            </div>

                            <!-- Edit Button -->
                            <a href="{{ route('journal.edit', $entry->id) }}" class="btn-edit">Edit</a>
                            
                            <!-- Toggle Favorite Form -->
                            <form action="{{ route('journal.toggleFavorite', $entry->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-favorite">
                                    {{ $entry->is_favorite ? 'Unfavorite' : 'Favorite' }}
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <a href="{{ route('journal.create') }}" class="btn-write">Write a New Journal Entry</a>
    </div>

    <script>
        function confirmDelete(entryId) {
            document.getElementById('delete-confirmation-' + entryId).style.display = 'block';
        }

        function closePopup(entryId) {
            document.getElementById('delete-confirmation-' + entryId).style.display = 'none';
        }
    </script>
</x-layout>
