<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->name;
    $user->bio = $request->bio;

    // Handle the avatar upload
    if ($request->hasFile('avatar')) {
        // Store the uploaded image in the public storage
        $path = $request->file('avatar')->store('avatars', 'public');

        // Save the path to the database
        $user->avatar = $path;
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
}

}
