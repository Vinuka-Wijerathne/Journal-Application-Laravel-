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

    // Ensure content is in the right format for Editor.js
    $journalEntry->content = json_decode($journalEntry->content, true); // Ensure it is an array

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
    public function search(Request $request)
{
    $query = $request->input('query');
    
    $journalEntries = JournalEntry::where(function($q) use ($query) {
        $q->whereDate('date', $query) // Check for date
          ->orWhere('content', 'LIKE', '%' . $query . '%'); // Check for content
    })->get();

    return view('journal.dashboard', compact('journalEntries'));
}

    public function favorites()
{
    $journalEntries = JournalEntry::where('is_favorite', true)->get();

    return view('journal.dashboard', compact('journalEntries'));
}
    public function toggleFavorite($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        $journalEntry->is_favorite = !$journalEntry->is_favorite; // Toggle favorite status
        $journalEntry->save();

        return redirect()->route('journal.dashboard')->with('success', 'Favorite status updated successfully.');
    }
    public function togglePost($id)
{
    $journal = JournalEntry::findOrFail($id);

    // Toggle the post status
    $journal->is_posted = !$journal->is_posted;
    $journal->save();

    return redirect()->route('journal.dashboard')->with('success', 'Journal entry status updated successfully.');
}

    public function uploadImage(Request $request)
{
    if($request->hasFile('upload')) {
        $originName = $request->file('upload')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->file('upload')->getClientOriginalExtension();
        $fileName = $fileName.'_'.time().'.'.$extension;

        $request->file('upload')->move(public_path('images'), $fileName);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = asset('images/'.$fileName); 
        $msg = 'Image uploaded successfully'; 
        $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        @header('Content-type: text/html; charset=utf-8'); 
        echo $re;
    }
}

}
