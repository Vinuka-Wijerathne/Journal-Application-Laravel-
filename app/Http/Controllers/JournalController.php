<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JournalEntry;
use Carbon\Carbon; // Import Carbon for date manipulation

class JournalController extends Controller
{
    public function create()
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login'); // Redirect to login if not authenticated
    }

    // Default date to today's date
    $defaultDate = now()->format('Y-m-d');

    return view('journal.create', compact('defaultDate'));
}


    public function index()
    {
        $user = Auth::user();
        $journalEntries = JournalEntry::where('user_id', $user->id)->get();
        return view('journal.dashboard', compact('journalEntries'));
    }

    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
    ]);

    $user = Auth::user();
    
    $journalEntry = new JournalEntry();
    $journalEntry->content = $request->input('content');
    $journalEntry->date = $request->input('date') ?: now(); // Use the provided date or today's date
    $journalEntry->user_id = $user->id;

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public'); // Store the image
        $journalEntry->image_path = $imagePath; // Save the image path
    }

    $journalEntry->save();

    return redirect()->route('journal.dashboard')->with('success', 'Journal entry saved successfully.');
}

    

    public function edit($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        return view('journal.edit', compact('journalEntry'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $journalEntry = JournalEntry::findOrFail($id);
        $journalEntry->content = $request->input('content');
        $journalEntry->save();

        return redirect()->route('journal.dashboard')->with('success', 'Journal entry updated successfully.');
    }

    public function destroy($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        $journalEntry->delete();

        return redirect()->route('journal.dashboard')->with('success', 'Journal entry deleted successfully.');
    }

    public function toggleFavorite($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        $journalEntry->is_favorite = !$journalEntry->is_favorite; // Toggle favorite status
        $journalEntry->save();

        return redirect()->route('journal.dashboard')->with('success', 'Favorite status updated successfully.');
    }
}
