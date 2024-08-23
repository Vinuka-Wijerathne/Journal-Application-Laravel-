<x-layout>
    <link rel="stylesheet" href="{{ asset('css/social.css') }}">
    <x-topbar />

    <div class="social-container">
        <!-- Tabs for switching between sections -->
        <div class="social-tabs">
            <button onclick="showSection('your-posts')">Your Posts</button>
            <button onclick="showSection('feed')">Feed</button>
            <button onclick="showSection('search')">Search Profiles</button>
        </div>

        <!-- Section: Your Posts -->
        <div id="your-posts" class="social-section">
            <div class="profile-header">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/profile.png') }}" alt="Profile" class="profile-pic">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->bio }}</p>
                <div class="follow-info">
                    <span>{{ $followers }} Followers</span>
                    <span>{{ $following }} Following</span>
                </div>
            </div>

            <div class="journal-posts">
                <h3>Your Posts</h3>
                @foreach($journals as $journal)
                    <div class="journal-entry">
                        <h4>{{ \Carbon\Carbon::parse($journal->date)->format('F j, Y') }}</h4>
                        <div class="journal-content">
                            @php
                                $contentBlocks = json_decode($journal->content, true);
                            @endphp

                            @if(is_array($contentBlocks) && isset($contentBlocks['blocks']))
                                @foreach($contentBlocks['blocks'] as $block)
                                    @if($block['type'] == 'paragraph')
                                        <p>{{ $block['data']['text'] }}</p>
                                    @elseif($block['type'] == 'list')
                                        <ul>
                                            @foreach($block['data']['items'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            @else
                                <p>No content available.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section: Feed -->
        <div id="feed" class="social-section" style="display:none;">
            <h3>Feed</h3>
            @foreach($feedPosts as $post)
                <div class="feed-entry">
                    <h4>{{ \Carbon\Carbon::parse($post->date)->format('F j, Y') }} - {{ $post->user->name }}</h4>
                    <div class="feed-content">
                        @php
                            $contentBlocks = json_decode($post->content, true);
                        @endphp

                        @if(is_array($contentBlocks) && isset($contentBlocks['blocks']))
                            @foreach($contentBlocks['blocks'] as $block)
                                @if($block['type'] == 'paragraph')
                                    <p>{{ $block['data']['text'] }}</p>
                                @elseif($block['type'] == 'list')
                                    <ul>
                                        @foreach($block['data']['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        @else
                            <p>No content available.</p>
                        @endif
                    </div>
                    <!-- Like and Comment Section -->
                    <div class="interaction-section">
                        <button class="like-button">{{ $post->likes_count }} Likes</button>
                        <button class="comment-button">Comment</button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Section: Search Profiles -->
        <div id="search" class="social-section" style="display:none;">
            <h3>Search Profiles</h3>
            <form method="GET" action="{{ route('social.search') }}">
                <input type="text" id="search-input" name="search" placeholder="Search profiles..." required>
                <button type="submit">Search</button>
            </form>

            <div id="search-results" class="search-results">
                @if(isset($searchResults) && count($searchResults) > 0)
                    @foreach($searchResults as $result)
                        <div class="search-entry">
                            <a href="{{ route('profiles.show', $result->id) }}"> <!-- Link to the profile page -->
                                <img src="{{ $result->avatar ? asset('storage/' . $result->avatar) : asset('images/profile.png') }}" alt="Profile" class="search-profile-pic">
                                <h4>{{ $result->name }}</h4>
                                @if($result->bio)
                                    <p>{{ $result->bio }}</p>
                                @endif
                            </a>
                            @if(Auth::user()->isFollowing($result->id))
                                <form action="{{ route('social.follow', $result->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="unfollow-button">Unfollow</button>
                                </form>
                            @else
                                <form action="{{ route('social.follow', $result->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="follow-button">Follow</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p>No results found.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.social-section');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }

        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value;

            if (query.length > 0) {
                fetch(`{{ route('social.search') }}?search=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        const resultsContainer = document.getElementById('search-results');
                        resultsContainer.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(result => {
                                resultsContainer.innerHTML += `
                                    <div class="search-entry">
                                        <a href="{{ route('profiles.show', '') }}/${result.id}"> <!-- Link to the profile page -->
                                            <img src="${result.avatar ? '{{ asset('storage') }}' + '/' + result.avatar : '{{ asset('images/profile.png') }}'}" alt="Profile" class="search-profile-pic">
                                            <h4>${result.name}</h4>
                                            <p>${result.bio}</p>
                                        </a>
                                        <form action="{{ route('social.follow', '') }}/${result.id}" method="POST">
                                            @csrf
                                            <button type="submit">${result.isFollowing ? 'Unfollow' : 'Follow'}</button>
                                        </form>
                                    </div>
                                `;
                            });
                        } else {
                            resultsContainer.innerHTML = '<p>No results found.</p>';
                        }
                    })
                    .catch(error => console.error('Error fetching search results:', error));
            } else {
                document.getElementById('search-results').innerHTML = '';
            }
        });
    </script>
</x-layout>
