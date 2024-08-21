<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $journalEntries = $user->journalEntries; // Assuming you have defined the relationship

        return view('journal.dashboard', compact('journalEntries'));
    }
}
