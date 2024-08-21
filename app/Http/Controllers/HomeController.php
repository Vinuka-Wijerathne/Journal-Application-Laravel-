<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;

class HomeController extends Controller
{
    public function index()
    {
        // Get all journal entries for the current month
        $journalEntries = JournalEntry::whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)
                                      ->get()
                                      ->keyBy(function ($entry) {
                                          return $entry->created_at->format('Y-m-d');
                                      });

        return view('home', compact('journalEntries'));
    }
}