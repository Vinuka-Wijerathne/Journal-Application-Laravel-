<x-layout>
    <link rel="stylesheet" href="{{ asset('css/profiles.css') }}">
    <x-topbar />

    <div class="profile-container">
        <div class="profile-header">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/profile.png') }}" alt="Profile" class="profile-pic">
            <h2>{{ $user->name }}</h2>
            @if(!empty($user->bio))
                <p>{{ $user->bio }}</p>
            @endif
            <div class="follow-info">
                <span>{{ $followers }} Followers</span>
                <span>{{ $following }} Following</span>
            </div>

            @if($isFollowing)
                <form action="{{ route('social.follow', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="unfollow-button">Unfollow</button>
                </form>
            @else
                <form action="{{ route('social.follow', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="follow-button">Follow</button>
                </form>
            @endif
        </div>
        
        <!-- Journal Entries Section -->
        <div class="journals-section">
            <h3>{{ $user->name }}'s Journal Entries</h3>
            @if($journals->isEmpty())
                <p>No journal entries posted yet.</p>
            @else
                <ul class="journal-list">
                    @foreach($journals as $journal)
                        <li class="journal-entry">
                            <h4>{{ \Carbon\Carbon::parse($journal->created_at)->format('M d, Y') }}</h4>
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
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>
