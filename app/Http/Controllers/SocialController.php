<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function showSocialPage()
    {
        $user = Auth::user();

        // Get only the journal entries that have been posted by the user
        $journals = $user->journalEntries()->where('is_posted', true)->get();

        // Get the feed (posts from people the user follows)
        $feedPosts = JournalEntry::whereIn('user_id', $user->following()->pluck('following_id'))
            ->where('is_posted', true)
            ->latest()
            ->get();

        // Get followers and following counts
        $followers = $user->followers()->count();
        $following = $user->following()->count();

        return view('social.index', compact('user', 'journals', 'feedPosts', 'followers', 'following'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $results = User::where('name', 'LIKE', "%{$query}%")->get();

        // Check if the current user follows each result
        foreach ($results as $result) {
            $result->isFollowing = Auth::user()->isFollowing($result->id);
        }

        return response()->json($results);
    }

    public function follow(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->following()->where('following_id', $user->id)->exists()) {
            // If already following, unfollow the user
            $currentUser->following()->detach($user->id);
        } else {
            // If not following, follow the user
            $currentUser->following()->attach($user->id);
        }

        return redirect()->back();
    }

    // Add a method to show a specific user's profile
    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->count();
        $following = $user->following()->count();
        $journals = $user->journalEntries()->where('is_posted', true)->get();

        return view('profiles.show', compact('user', 'followers', 'following', 'journals'));
    }
}
