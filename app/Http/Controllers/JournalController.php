<?php
// app/Http/Controllers/JournalController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JournalEntry;

class JournalController extends Controller
{
    public function create()
    {
        return view('journal.create');
    }
    public function edit($id)
    {
        $journalEntry = JournalEntry::findOrFail($id); // Retrieve the journal entry by ID
    
        return view('journal.edit', compact('journalEntry')); // Pass the journal entry to the edit view
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();

        $journalEntry = new JournalEntry();
        $journalEntry->content = $request->input('content');
        $journalEntry->date = now(); // Store the current time using Carbon
        $journalEntry->user_id = $user->id;

        $journalEntry->save();

        // Redirect to the main dashboard instead of 'journal.dashboard'
        return redirect()->route('dashboard')->with('success', 'Journal entry saved successfully.');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $journalEntry = JournalEntry::findOrFail($id);
    $journalEntry->content = $request->input('content');
    $journalEntry->save();

    return redirect()->route('dashboard')->with('success', 'Journal entry updated successfully.');
}

}
