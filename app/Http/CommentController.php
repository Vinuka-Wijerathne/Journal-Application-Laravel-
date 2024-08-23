<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Find the post
        $post = Post::findOrFail($postId);

        // Create the comment
        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Return the newly created comment along with the user who created it
        return response()->json([
            'success' => true,
            'comment' => $comment->load('user'), // Load user relationship to get avatar and name
        ]);
    }

    // Get comments for a specific post (if needed)
    public function index($postId)
    {
        // Find the post
        $post = Post::findOrFail($postId);

        // Get the comments for the post
        $comments = $post->comments()->with('user')->get();

        // Return comments as a JSON response
        return response()->json($comments);
    }

    // Optional: Delete a comment
    public function destroy($commentId)
    {
        // Find the comment
        $comment = Comment::findOrFail($commentId);

        // Check if the authenticated user is the owner of the comment
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete the comment
        $comment->delete();

        return response()->json(['success' => true]);
    }
}
